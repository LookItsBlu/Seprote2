/* Notification Drawer Beta 2.1                                                                         */
/* By: Lenglet Anthony                                                                                  */
/* Built for Seprote 2                                                                                  */
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
/*   notification type ('error', 'success', 'info', 'warning'),                                         */
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
        this.notificationCount = 0;

        this.notifDrawer = document.createElement("div");
        this.notifDrawer.classList.add(this.notificationDrawerName);
        document.body.appendChild(this.notifDrawer);
        this.drawerSelector = '.'+this.notificationDrawerName;

        //create css stylesheet to modify
        var styleEl = document.createElement('style');
        document.head.appendChild(styleEl);
        this.styleSheet = styleEl.sheet;

        //position the drawer according to the given placement
        var beginningCSS = "."+this.notificationDrawerName+" { position: fixed;";
        switch(this.drawerDirection) {
            case 'topleft':
                this.styleSheet.insertRule(beginningCSS+" top: "+this.drawerPadding+"px; left: "+this.drawerPadding+"px; }", 0);
                break;
            case 'topright':
                this.styleSheet.insertRule(beginningCSS+" top: "+this.drawerPadding+"px; right: "+this.drawerPadding+"px; }", 0);
                break;
            case 'bottomleft':
                this.styleSheet.insertRule(beginningCSS+" bottom: "+this.drawerPadding+"px; left: "+this.drawerPadding+"px; }", 0);
                break;
            case 'bottomright':
                this.styleSheet.insertRule(beginningCSS+" bottom: "+this.drawerPadding+"px; right: "+this.drawerPadding+"px; }", 0);
                break;
        }
    }

    //create the notification item
    sendNotification(type, content, timer) {
        var p = this;

        //create a new notificationitem object and push it to the notification list
        var notifObject = new notificationItem(p.drawerDirection, p.ownerDrawer, p.drawerPadding, p.styleSheet, timer);
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

            p.regroupNotif(notifObject.notifID-1);

            p.notifObjList.splice(notifObject.notifID-1, 1);
            notifObject.destroy(p.drawerDirection);
            p.notificationCount--;
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

        //Add timeout to automaticaly dispose of the notification
        notifObject.TimeoutFunc = setTimeout(
            function(){
                //get index of clicked notification
                var child = notifObject.notifHTML;

                var i = 0;
                while( (child = child.previousSibling) != null )
                  i++;

                if(i>0){p.regroupNotif(i);}

                p.notifObjList.splice(i, 1);
                notifObject.destroy(p.drawerDirection);
                p.notificationCount--;
            },
            notifObject.notifTimer
        );
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

        // BUG: Note pour les future mainteneur / dev de Seprote 3
        // Celui la est bizzare, donc je passe en francais pour
        // que ce soit plus facile a comprendre.
        //
        // Note: Le timeout est utilisé pour contourner le problème
        // pour le moment, mais une correction définitive serait mieux.
        //
        // Recréation: Sur la page login, appuyer sur le bouton
        // de connexion.
        //
        // Resultat: Une notification apparait sans animation, et
        // les actions de clique ne marchent pas.
        //
        // Cause: L'élément DOM crée en javascript n'est pas encore
        // entièrement chargé avant l'execution des fonctions
        // ajoutant les actions et créant l'animation.
        //
        // Solution: Refaire cette partie du code pour faire en
        // sorte qu'elle ne s'execute que lorsque l'élement DOM est
        // entièrement chargé.

        setTimeout(()=>{
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
        }, 10);

        // /BUG
    }


    //Regroup all the notifications together by moving the
    //ones after the newly deleted notification up or down
    regroupNotif(index) {
        var p = this;
        for(var i=index-1;i>=0;i--){
            switch(p.drawerDirection){
                case 'topright':
                case 'topleft':
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
