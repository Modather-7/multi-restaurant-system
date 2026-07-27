import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

var channel = Echo.private(`App.Models.Admin.${userID}`);
channel.notification(function(data) {
    console.log(data);
    alert(data.body);
});
