/*Vue.component('vote',{
  template:'<form>\
              <h4>{{title}}</h4>\
              <span v-for=""><input type="radio" name="option" >{{polloption}}</span>\
              ',
})*/
var app = new Vue({
			el:'#start',
      computed:{
        available: function(){
          return (this.options.length > 0) ? true : false;
        },
        btndisabled: function(){
          return (this.title == '') ? true : false;
        },
       
       
      },
      data:{
        options:[],
				new:'',
				warn:'',
        title:'',
       
        

      },
      methods:{
        create: function (){
					if (this.new == ''){
						this.warn = 'an entry is required';
					}else{
						this.options.push(this.new);
            this.new = '';

           // $('.modal').closeModal();

             $('.modal-close').click();
            $('#btnadd').text('Add Another Option');
					}
        }
      },


		});
