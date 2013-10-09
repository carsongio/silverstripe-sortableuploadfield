(function($) {
    $(function(){
        $.entwine('ss', function($) {
            $('ul.ss-uploadfield-files').entwine({
                onmatch:function(){
                    this._super();
                },
                onunmatch: function(){
                    this._super();
                }
            });

            $('.sortableupload .activesort').entwine({
                onclick:function(){
                    if(this.hasClass("active")){
                        try {
                            $(".sortableupload .ss-uploadfield-files").sortable("destroy");
                        } catch(e){};
                        this.removeClass("active");
                    }else{
                        this.addClass("active");
                        $( ".sortableupload .ss-uploadfield-files").sortable({
                            opacity: 1,
                            helper: function(e, ui) {
                                ui.children().each(function() {
                                    $(this).width($(this).width());
                                });
                                return ui;
                            },
                            update: function(event, ui) {
                                var data=[];
                                var dataItems = $('li', this);

                                for(var i=0;i < dataItems.length;i++) {
                                    data[i]=$(dataItems[i]).attr('data-fileid');
                                }

                                var url = ui.item.find('.ss-uploadfield-item-sort').data('href');
                                console.log(url);
                                $.post(url, {
                                    list: (data)
                                }, function(data, status){

                                });
                            }
                        });
                    }
                }
            });
        });
    });
})(jQuery);