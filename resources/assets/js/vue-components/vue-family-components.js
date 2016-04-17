/**
 * This modal is used to open up the soldiers' info.
 */
Vue.component('my-modal',{
    template:'#modal-template'
});

/** BUTTON WITH TOKEN COMPONENT. **/
/**
 * This component is used to request a new soldier and add it to the list.
 */
Vue.component('button-token',{
    template: '#button-with-token',
    props: ['token'],
    methods:{
        /**
         * Ajax POST request for a new Soldier.
         * If the user does not have enough IP a new soldier won't be added.
         * @param type
         */
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
                    if(myData['response'] == 'ERROR')
                        swal("Oops...", "Seems like you do not have enough influence points to get a new soldier! You need " + myData['data'].length * 25 + " IP ", "error");
                    else if(myData['response'] == 'OK') {
                        swal("Woops!", "You successfully hired a new soldier!", "success")
                        this.$dispatch('list-updated', myData['data']);
                        this.$dispatch('ip-updated');
                    }
                }.bind(this),
                dataType: 'json'
            });
        }
    }
})

/** CLICK INFLUENCE COMPONENT **/

Vue.component('get-click-influence',{
    props: ['token','remaining-ip-to-bonus'],
    template: '#get-click-influence-template',
    methods:{
        /**
         * Handles the click on the get influence button. If the user has clicked enough times it will send an ajax
         * request to handle the redeeming of the bonus.
         */
        gainInfluence : function(){
            if(this.remainingIpToBonus <= 0){
                swal("Uhm..!", "You already redeemed your bonus IP!", "warning")
            }
            else{
                this.remainingIpToBonus--;
                this.createAnimationPlusOne();
                if(this.remainingIpToBonus == 0)
                    this.redeemBonusIP();
            }
        },

        /**
         * Ajax POST request to redeem the bonus IP. It's called once the user has clicked enough times.
         */
        redeemBonusIP : function(){
            $.ajax({
                type: "POST",
                url: '/api/redeemBonusIP',
                data: {},
                beforeSend: function (request)
                {
                    request.setRequestHeader("X-CSRF-TOKEN", this.token);
                }.bind(this),
                success: function(myData){
                    this.$dispatch('bonus-ip-reached',myData);
                }.bind(this),
                dataType: 'json'
            });
        },

        /**
         * Gets a random 'in' animation among the animate.css framework.
         * @returns {string}
         */
        getRandomAnimationIn : function(){
            var items = ['fadeIn','zoomIn','bounceIn','slideInUp'];
            return items[Math.floor(Math.random()*items.length)]
        },

        /**
         * Creates a '+1' element that appears and disappears after a while. Triggered when the user clicks on the button.
         */
        createAnimationPlusOne : function(){
            var animEnds = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
            var button = $('#influenceByClick > button');
            button.addClass('animated pulse').one(animEnds, function(){
                $(this).removeClass('animated pulse');
            });
            var posx = (Math.random() * ($('#influenceByClick').width())).toFixed();
            //This is needed to avoid the +1 element to position itself on top of the button.
            if(posx >= button.position().left && posx <= (button.position().left+button.width()))
                Math.random() > 0.5 ? posx+=button.width() : posx-=button.width();

            var posy = (Math.random() * ($('#influenceByClick').height())).toFixed();
            var randTrans = this.getRandomAnimationIn();
            var newDiv = $('<p class="plusOne">+1</p>')
                .css({
                    'width':'10px',
                    'height':'10px',
                    'left':posx+'px',
                    'top':posy+'px',
                }).addClass('animated '+ randTrans)
                .one(animEnds, function(){
                    $(this).delay(500).stop().fadeOut();
                });

            $('#influenceByClick').append(newDiv);
        }

    }
})

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
            this.$dispatch('soldier-clicked',this.soldier);
        }
    }

});