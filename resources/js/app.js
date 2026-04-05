import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

if (typeof window.Echo !== 'undefined' && typeof window.userID !== 'undefined' && window.userID) {
    const channel = window.Echo.private(`App.Models.User.${window.userID}`);

    channel.notification('.my-event', function (data) {
        window.dispatchEvent(new CustomEvent('dashboard-notification', {
            detail: {
                title: data.title ?? 'New notification',
                body: data.body ?? '',
            },
        }));
    });
}
