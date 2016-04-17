new Vue({
    el: 'body',
    data:{
        totalIP:10,
        incrementPS: 0,
        soldiersList: [],
        activeSoldier: []
    },
    ready: function() {
        this.getTotalIP();
        this.getSoldiersList();
        setInterval(function () {
            this.totalIP += this.incrementPS;
        }.bind(this), 1000);
    },

    methods: {
        getTotalIP : function(){
            $.getJSON('/api/updateIP',function(myData){
                this.totalIP = parseFloat(myData['totalIP']);
                this.incrementPS = parseFloat(myData['incrementPS']);
            }.bind(this));
        },

        getSoldiersList : function(){
            $.getJSON('/api/getSoldiersList',function(myData){
                this.soldiersList = myData;
            }.bind(this));
        },
    },

    events: {
        'list-updated': function(list){
            this.getSoldiersList();
        },

        'ip-updated':function(){
            this.getTotalIP();
        },

        'soldier-clicked':function(soldier){
            this.activeSoldier = soldier;
        },

        'bonus-ip-reached' : function(data){
            if(data['response'] == 'ERROR')
                swal("Oops...", "Seems like you already redeemed your bonus IP for the day! Try again tomorrow ", "error");
            else if(data['response'] == 'OK') {
                swal("Good job!", "You've earned bonus Influence Points!", "success")
                this.totalIP += 100;
            }
        }
    }


});

