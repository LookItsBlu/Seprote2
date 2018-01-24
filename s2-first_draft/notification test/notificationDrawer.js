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


class notification {
    //initiate the notification drawer
    constructor(direction, drawerName) {
        this.ownerDrawer = drawerName;
        this.notificationDrawerName = 'notification-drawer-'+this.ownerDrawer;
        this.drawerDirection = direction;
        this.drawerPadding = 15;
        this.spaceBetweenNotifs = 15;
        
        //this list will contain all the notification item objects in this drawer
        this.notifObjList = [];
        
        this.notifDrawer = document.createElement("div");
        this.notifDrawer.classList.add(this.notificationDrawerName);
        document.body.appendChild(this.notifDrawer);
        this.drawerSelector = '.'+this.notificationDrawerName;
        
        //position the drawer according to the given placement
        var beginningCSS = "."+this.notificationDrawerName+" { position: fixed;";
        switch(this.drawerDirection) {
            case 'topleft':
                document.styleSheets[0].insertRule(beginningCSS+" top: "+this.drawerPadding+"px; left: "+this.drawerPadding+"px; }", 1);
                break;
            case 'topright':
                document.styleSheets[0].insertRule(beginningCSS+" top: "+this.drawerPadding+"px; right: "+this.drawerPadding+"px; }", 1);
                break;
            case 'bottomleft':
                document.styleSheets[0].insertRule(beginningCSS+" bottom: "+this.drawerPadding+"px; left: "+this.drawerPadding+"px; }", 1);
                break;
            case 'bottomright':
                document.styleSheets[0].insertRule(beginningCSS+" bottom: "+this.drawerPadding+"px; right: "+this.drawerPadding+"px; }", 1);
                break;
        }
    }
    
    //create the notification item
    sendNotification(type, content, timer) {
        var p = this;
        
        //create a new notificationitem object and push it to the notification list
        var notifObject = new notificationItem(p.drawerDirection, p.ownerDrawer, p.drawerPadding, timer);
        this.notificationCount++;
        notifObject.notifID = this.notificationCount;
        this.notifObjList.push(notifObject);
        
        //create and append the displayed notification
        content.owner = p.ownerDrawer;
        document.querySelector(this.drawerSelector).append(notifObject.create(type, content));
        
        //slide the notification into view
        this.pushNotifOnScreen(notifObject.notifHTML);
        
        //add notification events on mouseclick
        var mousedownHandler = function(e){
            e.preventDefault();
            e.target.style.transform = 'scale(0.95)';
        };
        
        var mouseupHandler = function(e) {
            //Close the notification
            e.preventDefault();
            
            //Before anything, make sure to disable the timeout
            clearTimeout(notifObject.TimeoutFunc);
            
            e.target.style.transform = 'scale(1)';
            var drawerlist = p.notifDrawer;

            //get index of clicked notification
            var child = e.target;
            var i = 0;
            while( (child = child.previousSibling) != null ) 
              i++;

            if(i>0){p.regroupNotif(i);}

            p.notifObjList.splice(i, 1);
            notifObject.destroy(p.drawerDirection);
        };
        
        var mouseoutHandler = function(e){
            e.preventDefault();
            e.target.style.transform = 'scale(1)';
        };
        
        notifObject.notifHTML.addEventListener("transitionend", function(e){
            notifObject.notifHTML.addEventListener("mousedown", mousedownHandler);
            notifObject.notifHTML.addEventListener("mouseup", mouseupHandler);
            notifObject.notifHTML.addEventListener("mouseout", mouseoutHandler);
        });
        
        //Add timeout to automaitcaly dispose of the notification
        notifObject.TimeoutFunc = setTimeout(function(){notifObject.destroy(p.drawerDirection)}, notifObject.notifTimer);
    }
    
    //push the notification item on screen
    pushNotifOnScreen(notif) {
        var p = this;
        
        //push every possible previous notifications down or up to make space for the new one
        for(var i=p.notifObjList.length-2;i>=0;i--){
            switch(p.drawerDirection){
                case 'topright':
                case 'topleft':
                    p.notifObjList[i].pushForward('top', i, p.notifObjList.length-1, p.spaceBetweenNotifs, p.drawerPadding);
                    break;
                case 'bottomright':
                case 'bottomleft':
                    p.notifObjList[i].pushForward('bottom', i, p.notifObjList.length-1, p.spaceBetweenNotifs, p.drawerPadding);
                    break;
            }
        }
        
        //slide the new notification into view
        window.requestAnimationFrame(function(){
            switch(p.drawerDirection) {
                case 'topleft':
                case 'bottomleft':
                    notif.style.left = '15px';
                    break;
                case 'topright':
                case 'bottomright':
                    notif.style.right = '15px';
                    break;
            }
        });
    }
    
    //Regroup all the notifications together by moving the
    //ones after the newly deleted notification up or down
    regroupNotif(index) {
        var p = this;
        for(var i=index-1;i>=0;i--){
            switch(p.drawerDirection){
                case 'topright':
                case 'topleft':
                    console.log(i);
                    p.notifObjList[i].pushBackward('top', i, p.notifObjList.length-1, p.spaceBetweenNotifs, p.drawerPadding);
                    break;
                case 'bottomright':
                case 'bottomleft':
                    p.notifObjList[i].pushBackward('bottom', i, p.notifObjList.length-1, p.spaceBetweenNotifs, p.drawerPadding);
                    break;
            }
        }
    }
}