new Vue({
    el: 'body',
    data:{
        totalIP:10
    },
    ready: function() {
        setInterval(function () {
            $.getJSON('/api/updateIP',function(mydata){
                this.totalIP = mydata;
            }.bind(this))
        }.bind(this), 1000);
    }
});
//# sourceMappingURL=all.js.map
