String.prototype.templator = function(a){var b = this;var c = b.match(/@@[a-zA-Z0-9]+@@/g);for(var i=0;i<c.length;i++){var b=b.replace(c[i], a[c[i].substring(2,c[i].length-2)]);}return b;};