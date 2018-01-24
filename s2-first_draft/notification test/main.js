var info = new notification('topright', 'info');
var update = new notification('bottomleft', 'update');
var error = new notification('bottomright', 'error');

Array.prototype.random = function () {
  return this[Math.floor((Math.random()*this.length))];
}
var notificationType = ['error', 'confirm', 'info', 'warning'];

function notify() {
    info.sendNotification(
        'info',
        {
            title: 'Info!',
            body: 'I\'m a notification, click here to close me!'
        },
        2000
    );
    
    update.sendNotification(
        'confirm',
        {
            title: 'Update!',
            body: 'I\'m a notification, click here to close me!'
        },
        500
    );
    
    error.sendNotification(
        'error',
        {
            title: 'Error!',
            body: 'I\'m a notification, click here to close me!'
        },
        5000
    );
    setTimeout(function(){requestAnimationFrame(notify);}, 3000);
}

requestAnimationFrame(notify);

console.log(notif.notifObjList);