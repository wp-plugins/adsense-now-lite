$(document).ready(function () {
  $('.colorpicker').on('hidePicker', function (e) {
    var color = e.color.toHex().replace('#', "");
    var pk = $(this).find('input').attr('id').replace('-value', '');
    var data = xparams;
    data.pk = pk;
    data.name = pk;
    data.value = color;
    data.action = 'update';
    $.ajax({url: 'ajax/options.php',
      type: 'POST',
      data: data,
      error: function (a) {
        flashError(a.responseText);
      }});
  });
  $('input[type=radio]').on('change', function (e) {
    var pk = $(this).attr('name');
    var value = $(this).attr('data-value');
    var data = {};
    $.each(xparams, function (key, value) {
      data[key] = value;
    });
    data.pk = pk;
    data.name = pk;
    data.value = value;
    data.action = 'update';
    $.ajax({url: 'ajax/options.php',
      type: 'POST',
      data: data,
      error: function (a) {
        flashError(a.responseText);
      }});
  });
  $.each(['categories', 'posts', 'pages'], function (key, val) {
    $("." + val).click(function () {
      var verb = $(this).attr('data-verb');
      var data = {};
      $.each(xparams, function (key, value) {
        data[key] = value;
      });
      data.pk = verb + '_' + val;
      data.name = data.pk;
      $.ajax({url: 'ajax/' + val + '.php',
        type: 'GET',
        data: data,
        success: function (a) {
          bootbox.confirm(a, function (result) {
            if (result) {
              var list = '';
              $('.selectit:checked').each(function () {
                list += $(this).val() + ',';
              });
              data.value = list;
              data.action = 'update';
              $.ajax({url: 'ajax/options.php',
                type: 'POST',
                data: data,
                success: function () {
                  flashSuccess("Saved list of " + val + " where the plugin will " + verb + ' ads.');
                },
                error: function (a) {
                  flashError(a.responseText);
                }});
            }
          });
        },
        error: function (a) {
          flashError(a.responseText);
        }});
    });
  });
});
