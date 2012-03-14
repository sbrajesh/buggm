(function($){
    var j=jQuery;
    j(document).ready(function(){
       //we will need to disable the select options on domready for already selected items//do later
       //for now, let us add the keywords
       var select_keyword=j("#buggm-keywords");
       var name=select_keyword.attr('name');
       name=name+"[]";//ok u should understand
       
       j("#buggm-keywords").live('change',function(){
           var $this=j(":selected",this);
           if($this.val()==0)
               return;
           $this.prop('disabled',true);
           var html="<input type='hidden' name='tax_input[keywords][]' id='hidden-keywords-"+$this.val()+"' value='"+$this.val()+"' /><span id='list-keywords-"+$this.val()+"' class='kw-selected'>"+$this.text()+"<span class='kw-remove'>X</span></span>";
         
          j(this).parent().parent().next().find(".buggm-keywords-holder").append(html);
       });
   
   //for removing tag
   j('span.kw-remove').live('click',function(evt){
       var el=j(evt.target).parents().get(0);
       el=j(el);
       var el_id=el.attr('id');
       var ids=el_id.split('-');
       el_id=ids[2];//the 3rd component
       //remove the hiddent element, remove teh span
       j('span#list-keywords-'+el_id).remove();
       j('input#hidden-keywords-'+el_id).remove();
       
       //re enable the option in dd
       j('#buggm-keywords option[value="'+el_id+'"]').prop('disabled',false);
       
   });
   
   j("#search_toggle").live('click',function(){
      //show the advance search
      j("#advance-filter").show();
   })
   
   j("#search_toggle-advance").live('click',function(){
       j("#advance-filter").hide();
   })
   
   //comment list hide/show
   j("#toggle-comments").toggle(function(){
       j(this).addClass('comment-toggled');
       j("#comment-list").hide();
       
   },function(){
       j("#comment-list").show();
        j(this).removeClass('comment-toggled');
   });
   
   
   /*main menu*/
     j('nav#main-menu ul li').hover(
        function () {
            //show its submenu
            j('ul', this).slideDown(100);
            if(j('ul', this).get(0))
            j(this).addClass('current-parent-item-hover');
        }, 
        function () {
            //hide its submenu
            j('ul', this).slideUp(100); 
            if(j('ul', this).get(0))
            j(this).removeClass('current-parent-item-hover');
        }
    );
   
   
    });//dom ready
    
})(jQuery);