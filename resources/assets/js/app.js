Vue.component('my-modal',{
    template:'#modal-template',
});

/** BUTTON WITH TOKEN COMPONENT **/
Vue.component('button-token',{
    template: '#button-with-token',
    props: ['token'],
    methods:{
        postNewSoldier : function(type){
            $.ajax({
                type: "POST",
                url: '/api/newSoldier',
                data: this.token,
                beforeSend: function (request)
                {
                    request.setRequestHeader("X-CSRF-TOKEN", this.token);
                }.bind(this),
                success: function(myData){
                    this.$dispatch('list-updated',myData);
                    this.$dispatch('ip-updated');
                }.bind(this),
                dataType: 'json'
            });
        }
    }
})

/**

/** SOLDIER LI COMPONENT **/

Vue.component('soldier-li',{
    template: '#soldierLi',
    props: ['soldier','token'],
    methods:{
        deleteSoldier : function(soldier){
            $.ajax({
                type: "POST",
                url: '/api/deleteSoldier/'+this.soldier.id,
                data: {},
                beforeSend: function (request)
                {
                    request.setRequestHeader("X-CSRF-TOKEN", this.token);
                }.bind(this),
                success: function(myData){
                    this.$dispatch('list-updated',myData);
                    this.$dispatch('ip-updated');
                }.bind(this),
                dataType: 'json'
            });
        },

        sendMessageToParent: function(){
            this.$dispatch('toggle-soldier',this.soldier);
        }
    }

});

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
                this.totalIP = myData['totalIP'];
                this.incrementPS = myData['incrementPS'];
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
            this.soldiersList = list;
        },

        'ip-updated':function(){
            this.getTotalIP();
        },

        'toggle-soldier':function(soldier){
            this.activeSoldier = soldier;
        }
    }


});

