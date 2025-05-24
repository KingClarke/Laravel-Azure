import Echo from 'laravel-echo';
import io from 'socket.io-client';
window.io = io;

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001',
    transports: ['websocket', 'polling'],
});

// Only run this on the group chat page
if (window.groupId) {
    window.Echo.private('group.' + window.groupId)
        .listen('GroupMessageSent', (e) => {
            // Option 1: Reload the page (simple, but not ideal)
            // location.reload();
            // Option 2: Append the new message (better UX)
            if (typeof addGroupMessageToChat === 'function') {
                addGroupMessageToChat(e.message, e.group);
            } else {
                location.reload();
            }
        });
}
