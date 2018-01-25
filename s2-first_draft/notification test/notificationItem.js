/* Notification Drawer Beta 2                                                                           */
/* By: Lenglet Anthony                                                                                  */
/*                                                                                                      */
/* A library that allows you to easily display windows 10 style notifications                           */
/*                                                                                                      */
/* Usage:                                                                                               */
/* new notification(                                                                                    */
/*   position of the notifications on the screen ('topleft', 'topright', 'bottomleft', 'bottomright'),  */
/*   name given to this notification 'drawer'                                                           */
/* );                                                                                                   */
/*                                                                                                      */
/* notif.sendNotification(                                                                              */
/*   notification type ('error', 'confirm', 'info', 'warning'),                                         */
/*   {                                                                                                  */
/*     title: 'Notification Title',                                                                     */
/*     body: 'Notification body'                                                                        */
/*   },                                                                                                 */
/*   time on screen (ms)                                                                                */
/* );                                                                                                   */


class notificationItem {
    constructor(direction, owner, padding, timer) {
        this.owner = owner;
        
        this.colorError = '#ff3014';
        this.colorConfirm = '#7be016';
        this.colorWarning = '#f8db39';
        this.colorInfo = '#a2ffe4';
        
        this.opacity = '0.9';
        
        this.notifWidth = 350;
        this.notifHeight = 125;
        this.itemPadding = padding;
        
        this.notifTimer = timer;
        this.TimeoutFunc;
        
        this.notificationHTML = "<div class='@@owner@@-notification-item'><div class='notification-content'><p class='notification-title'>@@title@@</p><p class='notification-body'>@@body@@</p></div></div>";
        
        var cssItemPos = '';
        switch(direction) {
            case 'topleft':
                cssItemPos = 'left: -'+this.notifWidth+'px; top: '+this.itemPadding+'px;';
                break;
            case 'topright':
                cssItemPos = 'right: -'+this.notifWidth+'px; top: '+this.itemPadding+'px;';
                break;
            case 'bottomleft':
                cssItemPos = 'left: -'+this.notifWidth+'px; bottom: '+this.itemPadding+'px;';
                break;
            case 'bottomright':
                cssItemPos = 'right: -'+this.notifWidth+'px; bottom: '+this.itemPadding+'px;';
                break;
        }
        
        document.styleSheets[0].insertRule("."+this.owner+"-notification-item { position: inherit; width: "+this.notifWidth+"px; height: "+this.notifHeight+"px; "+cssItemPos+" overflow: hidden; cursor: pointer; transition: transform 0.25s ease-out, right 0.25s ease-out, left 0.25s ease-out, top 0.25s ease-out, bottom 0.25s ease-out; }", 1);
        
        document.styleSheets[0].insertRule(".notification-content { padding: 15px 0 0 15px; pointer-events: none; }", 1);
        
        document.styleSheets[0].insertRule(".notification-error { background-color: "+this.colorError+"; opacity: "+this.opacity+"; }", 1);
        document.styleSheets[0].insertRule(".notification-confirm { background-color: "+this.colorConfirm+"; opacity: "+this.opacity+"; }", 1);
        document.styleSheets[0].insertRule(".notification-warning { background-color: "+this.colorWarning+"; opacity: "+this.opacity+"; }", 1);
        document.styleSheets[0].insertRule(".notification-info { background-color: "+this.colorInfo+"; opacity: "+this.opacity+"; }", 1);
        
        document.styleSheets[0].insertRule(".notification-title { margin: 0; font-size: 20px; font-weight: bold; }", 1);
        document.styleSheets[0].insertRule(".notification-body { font-size: 13px; }", 1);
    }
    
    create(notifType, data) {
        var p = this;
        
        var parser = new DOMParser();
        this.notifHTML = parser.parseFromString(this.notificationHTML.templator(data), "text/html");
        this.notifHTML = this.notifHTML.childNodes[0].childNodes[1].childNodes[0];
        this.notifHTML.classList.add("notification-"+notifType);
        
        return this.notifHTML;
    }
    
    pushForward(pos, itemIndex, itemCnt, margin, padding) {
        var itemPos = (itemCnt - itemIndex)-1;
        var newStyle = ((padding + (itemPos*this.notifHeight) + (itemPos*margin))+margin+this.notifHeight)+"px";
        
        if(pos=='bottom') {
            this.notifHTML.style.bottom = newStyle;
        } else if (pos=='top') {
            this.notifHTML.style.top = newStyle;
        }
    }
    
    pushBackward(pos, itemIndex, itemCnt, margin, padding) {
        var itemPos = (itemCnt - itemIndex);
        var newStyle = (padding + (itemPos*this.notifHeight) + (itemPos*margin))-(margin+this.notifHeight)+"px";
        
        if(pos=='bottom') {
            this.notifHTML.style.bottom = newStyle;
        } else if (pos=='top') {
            this.notifHTML.style.top = newStyle;
        }
    }
    
    destroy(pos) {
        switch(pos) {
            case 'topright':
            case 'bottomright':
                this.notifHTML.style.right = '-'+this.notifHTML.offsetWidth+"px";
                break;
            case 'topleft':
            case 'bottomleft':
                this.notifHTML.style.left = '-'+this.notifHTML.offsetWidth+"px";
                break;
        }
        this.notifHTML.addEventListener("transitionend", function(e){
            e.target.remove();
        });
    }
}