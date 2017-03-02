require('bootstrap-sass');
require('chart.js');

jQuery(document).ready(function($){
  "use strict";
  var Site = function(){
    var
    b,
    t,
    f,
    formData,
    action,
    url;
    var bLoading = function() {
      if(b.hasClass('loading')){
        b.removeClass('loading');
      } else {
        b.addClass('loading');
      }
    };
    var ajaxCallback = function(f, u, c, t) {
      t = typeof t !== 'undefined' ? t : 'POST';
      bLoading();
      if (f) {
        $.ajax({
          type: t,
          url: u,
          data: f,
          dataType: 'json'
          // }).done(function (d, status, xhr) {
        }).done(function(d) {
          bLoading();
          c(d);
        }).fail(function(jqXHR, textStatus) {
          console.log("Request failed: " + textStatus);
          bLoading();
        });
      }
    };
    var removeFieldError = function() {
      if ($('.has-error').length > 0) {
        $('.has-error').find('.help-block').remove();
        $('.has-error').removeClass('has-error');
      }
      $('.error-block').remove();
    };
    var showFieldError = function(errors, f) {
      console.log(errors);
      // removeFieldError();
      $.each(errors, function(i, v) {
        var field = f.find('[name="' + i + '"]');
        if (field.length > 0) {
          var errorblock = '<span id="' + i + '-error" class="help-block">' + v.join(', ') + '</span>';
          if (field.parents('.checkbox').length || field.parents('.radio').length) {
            field.closest('.form-group').addClass('has-error').children('label').append(errorblock);
          } else if (field.parents('.input-group').length) {
            field.addClass('has-error').parent().after(errorblock);
            field.closest('.input-group').addClass('has-error');
          } else {
            field.parent().addClass('has-error');
            field.parent().append(errorblock);
          }
        }
      });
    };
    var generalRule = {
      search: {
        required: true
      },
      access_level: {
        required: true
      }
    };
    var generalMessage = {
      title: 'Please provide title',
      access_level: 'Please select Who could see your list'
    };
    var initValidate = function() {
      if(typeof $.validator !== 'undefined'){
        if ($('.validate').length > 0) {
          $('.validate').validate({
            rules: generalRule,
            messages: generalMessage,
          });
        }
      }
    };
    var initButton = function(){
      $(document).on('click','button, .btn, .hasAction',function(e){
        b = $(this);
        action = b.data('action');
        if (action && !b.hasClass('loading')) {
          e.preventDefault();
          if (b.hasClass('noform')) {
            actions(b, action);
          } else if (b.closest('form').length > 0) {
            f = b.closest('form');
            removeFieldError();
            // If validator defined then check
            if(typeof $.validator !== 'undefined'){
              if(b.hasClass('dontvalidate')){
                actions(b, action, f);
              } else {
                if (f.valid()) {
                  actions(b, action, f);
                }
              }
            } else {
              actions(b, action, f);
            }
          } else {
            actions(b, action);
          }
        }
      })
    };
    var actions = function(){
      if (typeof f !== 'undefined') {
        formData = f.serialize();
      }
      switch (action) {
        case 'store':
          var type = b.data('type');
          ajaxCallback(formData, '/'+type+'/store', function(d) {
            if (d.status === false) {
              showFieldError(d.errors,f);
            } else {
              window.location = d.url;
            }
          });
          break;
        case 'toggleDiv':
          var div = b.data('div');
          var hide = b.data('hide');
          if($('.'+div).length){
            $('.'+div).slideToggle();
          }
          if($('.'+hide).length){
            $('.'+hide).slideUp();
          }
          break;
        case 'logout':
          $('#logout-form').submit();
          break;
        case 'delete':
          ajaxCallback(formData, '/delete', function(d) {
            if (d.status === false) {
              b.parent().append(d.message).wrap('<div class="alert-danger alert"></div>');
            } else {
              b.parent().append(d.message).wrap('<div class="alert-success alert"></div>');
              b.remove();
              $('tr[data-id="'+d.id+'"]').hide();
            }
          });
          break;
        case 'modal':
          var modalaction = b.data('modalaction');
          $.each(b.data(),function(i,v){
            if (i !== 'modal') {
              if( i == 'modaldata'){
                v = JSON.stringify(v);
              }
              formData = formData+'&'+i+'='+v;
            }
          });
          $('#'+modalaction+'Modal').remove();
          ajaxCallback(formData, '/buildmodal', function(d) {
            if (d.status === false) {
              console.log(d);
            } else {
              $('body').append(d.view);
              afterModal();
              $('#'+modalaction+'Modal').modal('show');
            }
          });
          break;
        default:
          console.log('Not registered action');
          break;
      }
    };
    var afterModal = function(){
      preventSubmit();
      initButton();
    };
    var initValidateDefaults = function(){
      if(typeof $.validator !== 'undefined'){
        $.validator.setDefaults({
          messages: {
            required: 'This field is required',
          },
          highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
          },
          unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
          },
          errorElement: 'span',
          errorClass: 'help-block',
          errorPlacement: function(error, element) {
            if (element.parent('.input-group').length) {
              error.insertAfter(element.parent());
            } else if (element.parents('.checkbox').length || element.parents('.radio').length) {
              //console.log(element);
              error.insertAfter(element.closest('.form-group').children('label'));
            } else {
              error.insertAfter(element);
            }
          }
        });
      }
    };
    var preventSubmit = function(){
      if($('.preventSubmit').length){
        $('.preventSubmit').on('submit',function(e){
          $(this).find('.hasAction').click();
          return false;
        })
      }
    };
    var jiraCheckbox = function(){
      $('#jira_checkbox').prop('checked', false);
      $('#jira_checkbox').change(function(){
        if(this.checked)
        $('#jira_settings').fadeIn('fast');
        else
        $('#jira_settings').fadeOut('fast');
      });
    };
    var initPrivate = function(){
      $(document).on('change','input[name="private"]',function(){
        console.log($(this).val());
        if($(this).val() === '0'){
          $('.assignments-container').show();
        } else {
          $('.assignments-container').hide();
        }
      });
    };
    var initPlatformTypeField = function(){
      if($('#platform_type_id').length){
        $(document).on('change','#platform_type_id',function(){
          f = $('#platform_type_id').closest('form');
          b = f.find('.btn');
          formData = f.serialize();
          ajaxCallback(formData, '/platform/typefield', function(d) {
            if (d.status === false) {
            } else {
              f.find('.platformtypefields').html(d.view);
            }
          });
        });
      }
    };
    var initOpentab = function(){
      // Javascript to enable link to tab
      var url = document.location.toString();
      if (url.match('#')) {
        $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
      }

      // Change hash for page-reload
      $('.nav-tabs a').on('shown.bs.tab', function (e) {
        window.location.hash = e.target.hash;
      })
    };
    var buildChart = function(){
      if($('#myChart').length){
        var ctx = document.getElementById("myChart");
        var myChart = new Chart(ctx, {
          type: 'bar',
          data: {
            //labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
            datasets: [{
              label: 'PM 2.5',
              data: [12, 19, 3, 5, 2, 3],
              backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
              ],
              borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true
                }
              }]
            }
          }
        });
      }
    };
    var init = function(){
      initPrivate();
      initButton();
      initValidateDefaults();
      initValidate();
      preventSubmit();
      jiraCheckbox();
      initPlatformTypeField();
      initOpentab();
      buildChart();
      console.log('Web JS initiated');
    };
    return {
      init: init
    };
  }();
  Site.init();
});
