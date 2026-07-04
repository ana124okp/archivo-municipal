/**
 * FUNCIONES JAVASCRIPT COMPARTIDAS
 * Sistema de Gestión de Archivos Municipales
 */

// ==================== UTILIDADES ====================

/**
 * Mostrar alerta
 */
function showAlert(message, type = 'info') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;
    
    const container = document.querySelector('.content-container') || document.body;
    container.insertBefore(alertDiv, container.firstChild);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

/**
 * Mostrar modal
 */
function showModal(title, content, buttons = []) {
    let modal = document.getElementById('genericModal');
    
    if (!modal) {
        modal = document.createElement('div');
        modal.id = 'genericModal';
        modal.className = 'modal-overlay';
        modal.innerHTML = `
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"></h3>
                    <button class="modal-close">&times;</button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer"></div>
            </div>
        `;
        document.body.appendChild(modal);
        
        modal.querySelector('.modal-close').addEventListener('click', () => {
            modal.classList.remove('show');
        });
    }
    
    modal.querySelector('.modal-title').textContent = title;
    modal.querySelector('.modal-body').innerHTML = content;
    
    const footer = modal.querySelector('.modal-footer');
    footer.innerHTML = '';
    buttons.forEach(btn => {
        const button = document.createElement('button');
        button.className = `btn ${btn.class || 'btn-secondary'}`;
        button.textContent = btn.text;
        button.addEventListener('click', btn.onClick);
        footer.appendChild(button);
    });
    
    modal.classList.add('show');
}

/**
 * Cerrar modal
 */
function closeModal() {
    const modal = document.getElementById('genericModal');
    if (modal) {
        modal.classList.remove('show');
    }
}

/**
 * Fetch API con manejo de errores
 */
async function apiCall(url, method = 'GET', data = null) {
    try {
        const options = {
            method: method,
            headers: {
                'Content-Type': 'application/json',
            }
        };
        
        if (data) {
            options.body = JSON.stringify(data);
        }
        
        const response = await fetch(url, options);
        const result = await response.json();
        
        if (!response.ok) {
            throw new Error(result.message || 'Error en la solicitud');
        }
        
        return result;
    } catch (error) {
        showAlert('Error: ' + error.message, 'danger');
        console.error('API Error:', error);
        return null;
    }
}

/**
 * Formatear fecha
 */
function formatDate(dateString) {
    const options = {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    };
    return new Date(dateString).toLocaleDateString('es-ES', options);
}

/**
 * Formatear hora
 */
function formatTime(dateString) {
    const options = {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    };
    return new Date(dateString).toLocaleTimeString('es-ES', options);
}

/**
 * Validar email
 */
function isValidEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

/**
 * Validar contraseña (mínimo 6 caracteres)
 */
function isValidPassword(password) {
    return password.length >= 6;
}

/**
 * Generar tabla HTML desde array
 */
function generateTable(data, columns) {
    if (!data || data.length === 0) {
        return '<p class="text-center">No hay datos disponibles</p>';
    }
    
    let html = '<table class="table"><thead><tr>';
    
    // Headers
    columns.forEach(col => {
        html += `<th>${col.label}</th>`;
    });
    html += '<th>Acciones</th></tr></thead><tbody>';
    
    // Rows
    data.forEach(row => {
        html += '<tr>';
        columns.forEach(col => {
            const value = col.render ? col.render(row[col.key]) : row[col.key];
            html += `<td>${value}</td>`;
        });
        html += `<td class="table-actions">
                    <button class="btn-edit" data-id="${row.id}">Editar</button>
                    <button class="btn-delete" data-id="${row.id}">Eliminar</button>
                </td>`;
        html += '</tr>';
    });
    
    html += '</tbody></table>';
    return html;
}

/**
 * Exportar tabla a CSV
 */
function exportTableToCSV(tableId, filename = 'export.csv') {
    const table = document.getElementById(tableId);
    if (!table) return;
    
    let csv = [];
    const rows = table.querySelectorAll('tr');
    
    rows.forEach(row => {
        const cols = row.querySelectorAll('td, th');
        let csvRow = [];
        cols.forEach(col => {
            csvRow.push('"' + col.textContent.trim() + '"');
        });
        csv.push(csvRow.join(','));
    });
    
    downloadCSV(csv.join('\n'), filename);
}

/**
 * Descargar CSV
 */
function downloadCSV(csv, filename) {
    const link = document.createElement('a');
    link.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
    link.download = filename;
    link.click();
}

/**
 * Toggle sidebar en móvil
 */
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.sidebar-overlay') || createSidebarOverlay();
    
    sidebar.classList.toggle('show');
    overlay.classList.toggle('show');
}

/**
 * Crear overlay para sidebar
 */
function createSidebarOverlay() {
    const overlay = document.createElement('div');
    overlay.className = 'sidebar-overlay';
    overlay.addEventListener('click', toggleSidebar);
    document.body.appendChild(overlay);
    return overlay;
}

/**
 * Inicializar eventos comunes
 */
document.addEventListener('DOMContentLoaded', function() {
    // Cerrar modal al hacer click fuera
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('genericModal');
        if (modal && e.target === modal) {
            modal.classList.remove('show');
        }
    });
    
    // Cerrar dropdown al hacer click fuera
    document.addEventListener('click', function(e) {
        const dropdowns = document.querySelectorAll('.dropdown-menu.show');
        dropdowns.forEach(dropdown => {
            if (!dropdown.closest('.dropdown')) {
                dropdown.classList.remove('show');
            }
        });
    });
});

/**
 * Formatear moneda
 */
function formatCurrency(amount) {
    return new Intl.NumberFormat('es-MX', {
        style: 'currency',
        currency: 'MXN'
    }).format(amount);
}

/**
 * Confirmar acción
 */
function confirmAction(message, callback) {
    showModal('Confirmar', message, [
        {
            text: 'Cancelar',
            class: 'btn-secondary',
            onClick: closeModal
        },
        {
            text: 'Confirmar',
            class: 'btn-danger',
            onClick: () => {
                callback();
                closeModal();
            }
        }
    ]);
}

/**
 * Limpiar formulario
 */
function clearForm(formId) {
    const form = document.getElementById(formId);
    if (form) {
        form.reset();
    }
}
