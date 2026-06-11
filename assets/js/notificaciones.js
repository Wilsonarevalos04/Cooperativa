document.addEventListener('DOMContentLoaded', () => {
    // Encontrar el botón de la campana en el header
    const bellBtn = document.querySelector('.user-profile button');
    if (!bellBtn) return;

    // Crear el contenedor del dropdown
    const dropdown = document.createElement('div');
    dropdown.className = 'notifications-dropdown';
    dropdown.style.cssText = 'display: none; position: absolute; right: 0; top: calc(100% + 15px); width: 340px; background: white; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.15); overflow: hidden; z-index: 1000; border: 1px solid rgba(0,0,0,0.05); flex-direction: column; cursor: default;';
    
    dropdown.innerHTML = `
        <div style="padding: 16px 20px; border-bottom: 1px solid #e2e8f0; font-weight: 600; display: flex; justify-content: space-between; align-items: center; background: #fff;">
            <span style="font-size: 1.05rem;">Notificaciones</span>
            <span class="badge" id="notif-badge-header" style="background:#ef4444;color:white;padding:3px 10px;border-radius:12px;font-size:0.75rem;">0</span>
        </div>
        <div class="notif-list" style="max-height: 380px; overflow-y: auto; padding: 0;">
            <div style="padding: 20px; text-align: center; color: var(--text-light);"><i class="ph ph-spinner ph-spin" style="font-size: 1.5rem;"></i></div>
        </div>
        <div style="padding: 12px; text-align: center; border-top: 1px solid #e2e8f0; font-size: 0.85rem; background: #f8fafc;">
            <a href="#" id="mark-all-read" style="color: var(--primary-color); text-decoration: none; font-weight: 600; transition: color 0.2s;">Marcar todas como leídas</a>
        </div>
    `;

    // Añadirlo al .user-profile
    const userProfile = document.querySelector('.user-profile');
    if(userProfile) {
        userProfile.style.position = 'relative'; // Asegurarnos de que el relative esté presente
        userProfile.appendChild(dropdown);
    }

    // El punto rojo es el span dentro del botón (lo creamos si no existe)
    let redDot = bellBtn.querySelector('span'); 
    if (!redDot) {
        redDot = document.createElement('span');
        redDot.style.cssText = 'position: absolute; top: 0; right: 0; width: 10px; height: 10px; background: #ef4444; border-radius: 50%; border: 2px solid white;';
        bellBtn.appendChild(redDot);
    }
    redDot.style.display = 'none'; // oculto por defecto

    const notifList = dropdown.querySelector('.notif-list');
    let isDropdownOpen = false;

    // Función para obtener las notificaciones de la base de datos
    const fetchNotifs = () => {
        fetch('api_notificaciones.php?action=get')
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                // Actualizar punto rojo y contadores
                if(data.unread_count > 0) {
                    redDot.style.display = 'block';
                    document.getElementById('notif-badge-header').textContent = data.unread_count + ' nuevas';
                } else {
                    redDot.style.display = 'none';
                    document.getElementById('notif-badge-header').textContent = '0';
                    document.getElementById('notif-badge-header').style.background = '#94a3b8';
                }

                if(data.notificaciones.length === 0) {
                    notifList.innerHTML = `<div style="padding: 40px 16px; text-align: center; color: var(--text-light);">
                        <i class="ph-fill ph-check-circle" style="font-size:3rem;color:var(--secondary-color);margin-bottom:12px;opacity:0.8;"></i><br>
                        <span style="font-weight: 500;">Estás al día</span><br>
                        <span style="font-size: 0.85rem;">No tienes nuevas notificaciones.</span>
                    </div>`;
                } else {
                    notifList.innerHTML = data.notificaciones.map(n => `
                        <div style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9; background: ${n.leido == 0 ? '#f0fdf4' : 'white'}; display: flex; gap: 14px; align-items: flex-start; transition: background 0.2s;">
                            <div style="background: ${n.leido == 0 ? 'var(--secondary-color)' : '#e2e8f0'}; color: ${n.leido == 0 ? 'white' : 'var(--text-light)'}; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: ${n.leido == 0 ? '0 4px 10px rgba(16,185,129,0.2)' : 'none'};">
                                <i class="ph-fill ${n.titulo.toLowerCase().includes('seguridad') ? 'ph-shield-check' : (n.titulo.toLowerCase().includes('venc') ? 'ph-warning-circle' : 'ph-bell-ringing')}" style="font-size: 1.2rem;"></i>
                            </div>
                            <div style="flex: 1;">
                                <div style="font-weight: 700; font-size: 0.95rem; color: var(--text-dark); margin-bottom: 4px;">${n.titulo}</div>
                                <div style="font-size: 0.85rem; color: var(--text-light); line-height: 1.4;">${n.mensaje}</div>
                                <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 8px; display: flex; align-items: center; gap: 4px;">
                                    <i class="ph ph-clock"></i> ${n.fecha_creacion}
                                </div>
                            </div>
                            ${n.leido == 0 ? '<div title="No leída" style="width: 10px; height: 10px; background: var(--secondary-color); border-radius: 50%; margin-top: 8px; box-shadow: 0 0 0 3px rgba(16,185,129,0.2);"></div>' : ''}
                        </div>
                    `).join('');
                }
            }
        })
        .catch(console.error);
    }

    const markAllRead = (e) => {
        if(e) e.preventDefault();
        fetch('api_notificaciones.php?action=mark_read', {method: 'POST'})
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') fetchNotifs();
        }).catch(console.error);
    };

    // Toggle dropdown
    bellBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        isDropdownOpen = !isDropdownOpen;
        dropdown.style.display = isDropdownOpen ? 'flex' : 'none';
        
        // Si se abre, actualizamos los datos para que estén frescos
        if (isDropdownOpen) {
            fetchNotifs();
        }
    });

    document.getElementById('mark-all-read').addEventListener('click', markAllRead);

    // Evitar propagación al hacer click dentro del dropdown para que no se cierre
    dropdown.addEventListener('click', (e) => {
        e.stopPropagation();
    });

    // Close on out-click
    document.addEventListener('click', (e) => {
        if (!userProfile.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.style.display = 'none';
            isDropdownOpen = false;
        }
    });

    // Cargar historial inicial
    fetchNotifs();
});
