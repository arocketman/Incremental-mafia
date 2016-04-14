new Vue({
    el: 'body',
    data:{
        totalIP:10,
        incrementPS: 0
    },
    ready: function() {
        $.getJSON('/api/updateIP',function(myData){
            this.totalIP = myData['totalIP'];
            this.incrementPS = myData['incrementPS'];
        }.bind(this));

        setInterval(function () {
            this.totalIP += this.incrementPS;
        }.bind(this), 1000);
    }
});