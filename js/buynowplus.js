(function() {
  tinymce.create('tinymce.plugins.buynowplus', {

    init : function(ed, url) {
      ed.addButton('buynow', {
        title : 'Buy Now',
        type: 'button',
        image : url + '/../images/BUY_64X64_white.png',
        onclick: function () {
          jQuery.ajax({
            type: 'get',
            url: ajaxurl,
            data: {action : 'bnp_query_buttons'},
            success: function(res) {
              var buttons = [];
              var listboxValues = [];

              // console.log(res);

              if (res.success) {
                buttons = JSON.parse(res.data);

                // console.log(buttons);

                buttons.forEach(function (btn, index) {
                  listboxValues.push({text: btn.terms, value: index});
                })

                ed.windowManager.open( {
                  title: 'Select Button',
                  body: [
                    {
                      type: 'listbox',
                      name: 'buttons',
                      label: 'Buttons',
                      values: listboxValues
                    }
                  ],
                  onsubmit: function(e) {
                    // The value of the selected button aligns with the index of buttons array
                    var index = e.data.buttons;
                    var shortcode = '[buynowplus button="' + buttons[index]['_id'] + '" title="' + buttons[index]['description'] + '" type="link" ' + 'url="' + buttons[index]['short_url'] + '"]' + buttons[index]['terms'] + '[/buynowplus]';

                    ed.execCommand('mceInsertContent', false, shortcode);
                  }
                });
              } // end if
            }
          });
        }
      });
    },

    getInfo : function() {
      return {
        longname : 'Buy Now Plus',
        author : 'Caseproof, LLC',
        authorurl : 'http://caseproof.com/',
        infourl : 'https://buynowplus.com',
        version : "0.1"
      };
    }
  });

  // Register plugin
  tinymce.PluginManager.add( 'buynowplus', tinymce.plugins.buynowplus );
})();
