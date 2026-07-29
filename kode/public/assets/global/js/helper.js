"use strict";

//toaster functions
function toastr(text, className) {
  const isRTL = document.body.getAttribute("dir") === "rtl";

  if (className === "danger" || className === "error") {
    className = "bg-danger";
  } else {
    className = "bg-soft-" + className;
  }

  Toastify({
    newWindow: true,
    text: text,
    gravity: "top",
    position: isRTL ? "left" : "right", 
    className: className,
    stopOnFocus: true,
    offset: { x: 0, y: 0 },
    duration: 3000,
    close: true,
  }).showToast();
}

toastr.success = function(text) { toastr(text, "success"); };
toastr.error = function(text) { toastr(text, "danger"); };
toastr.warning = function(text) { toastr(text, "warning"); };
toastr.info = function(text) { toastr(text, "info"); };
toastr.danger = function(text) { toastr(text, "danger"); };

// Universal copy to clipboard helper
function copyTextToClipboard(text, btn, defaultHtml, customSuccessCallback) {
  if (!text) {
    toastr("Nothing to copy!", "danger");
    return;
  }

  function onSuccess() {
    if (typeof customSuccessCallback === "function") {
      customSuccessCallback();
    } else if (btn && defaultHtml) {
      btn.innerHTML = '<i class="bi bi-check me-1"></i> Copied!';
      setTimeout(() => { btn.innerHTML = defaultHtml; }, 2000);
    }
    toastr("Copied to clipboard!", "success");
  }

  if (navigator.clipboard && window.isSecureContext) {
    navigator.clipboard.writeText(text).then(onSuccess).catch(() => {
      fallbackCopyText(text, onSuccess);
    });
  } else {
    fallbackCopyText(text, onSuccess);
  }
}

function fallbackCopyText(text, onSuccess) {
  const textarea = document.createElement("textarea");
  textarea.value = text;
  textarea.style.position = "fixed";
  textarea.style.top = "0";
  textarea.style.left = "0";
  textarea.style.width = "1px";
  textarea.style.height = "1px";
  textarea.style.padding = "0";
  textarea.style.border = "none";
  textarea.style.outline = "none";
  textarea.style.boxShadow = "none";
  textarea.style.background = "transparent";
  textarea.style.opacity = "0.01";
  textarea.style.pointerEvents = "none";
  textarea.style.zIndex = "-9999";

  document.body.appendChild(textarea);
  textarea.focus();
  textarea.select();
  textarea.setSelectionRange(0, 999999);

  let successful = false;
  try {
    successful = document.execCommand("copy");
  } catch (err) {
    successful = false;
  }
  document.body.removeChild(textarea);

  if (successful) {
    onSuccess();
  } else {
    window.prompt("Copy to clipboard: Press Ctrl+C, Enter", text);
    onSuccess();
  }
}





//EMPTY INPUT FIELD 
function emptyInputFiled(id, selector = 'id', html = true) {
    var identifier = selector === 'id' ? `#${id}` : `.${id}`;
    $(identifier)[html ? 'html' : 'val']('');
}


const disableInput = document.querySelectorAll('input[disabled]');
disableInput.forEach(element => {
  element.style.cssText = `background-color: rgba(0,0,0,0.025);`;
});


//file upload preview
$(document).on('change', '.preview', function (e) {
    var file = e.target.files[0];
    var size = ($(this).attr('data-size')).split("x");
    $(this).closest('div').find('.image-preview-section').html(
        `<img alt='${file.type}' class="mt-2 img-100 rounded  d-block"
            
            src='${URL.createObjectURL(file)}'>`
    );
    e.preventDefault();
})



$(document).on('click','.code-generate',function(e){
     $("#referral_code").val(generateRandomNumber());
     toastr("New Code generated",'success')
     e.preventDefault()
 })


 function generateRandomNumber() {
    const randomNumber = Math.floor(Math.random() * 900000) + 100000;
    return randomNumber;
  }



 $(document).on('click','.key-generate',function(e){
    e.preventDefault()

    $("#webhook_api_key").val(generateSecureApiKey(32));

    toastr( "New key generated",'success')

 })

 function generateSecureApiKey(length = 32) {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuv==wxyz0123456789+/';
    let result = '';

    for (let i = 0; i < length; i++) {
        const randomIndex = Math.floor(Math.random() * characters.length);
        result += characters.charAt(randomIndex);
    }

    while (result.length % 4 !== 0) {
        result += '=';
    }

    return result;
}



$(document).on('click', '.copy-text ', function (e) {
    
    var data = $(this).attr('data-text')
    var modal = $(this).attr('data-type');

    var $tempInput = $('<input>');
  
    if(modal){
        $('.modal').append($tempInput);
    }else{
        $('body').append($tempInput);
    }


    $tempInput.val(data).select();
  
    document.execCommand('copy');
    $tempInput.remove();

    toastr('URL Copied Successfully', 'success')
})

function send_browser_notification(heading, icon, message, route) {
    Push.create(`${heading}`, {
        body: message,
        icon: `${icon}`,
        timeout: 4000,
        onClick: function () {
            window.location.href = route
            this.close();
        }
    });
}

function checkebox_event(selector, sub_selector) {

    var length = $(`${selector}`).length;
    var checked_length = $(`${selector}:checked`).length;
    if (length == checked_length) {
        $(`${sub_selector}`).prop('checked', true);
    }
    else {
        $(`${sub_selector}`).prop('checked', false);
    }
    return length;
}

// CHECK BOX METHOD 
function checkUncheckMethod(selector, status, type = 'class') {
    if (type == 'class') {
      $(`.${selector}`).prop('checked', status)
    }
    else {
      $(`#${selector}`).prop('checked', status)
    }
  }
// ALL DATA SELECT 
$(document).on('click', '#select-all', function (e) {
    if ($(this).is(':checked')) {
      checkUncheckMethod(`all-data-select input[type=checkbox]`, true)
    } else {
      checkUncheckMethod(`all-data-select input[type=checkbox]`, false)
    }
})
/** bulk action js start */

$(document).on('click','.check-all' ,function(e){
    if($(this).is(':checked')){
        $(`.data-checkbox`).prop('checked', true);
        $(`.bulk-action`).removeClass('d-none');
    }
    else{
        $(`.data-checkbox`).prop('checked', false);
        $(`.bulk-action`).addClass('d-none');
    }
})

$(document).on('click','.data-checkbox' ,function(e){
     var length = checkebox_event(".data-checkbox",'.check-all');
     if(length > 0){
        $(`.bulk-action`).removeClass('d-none');
     }
     else{
        $(`.bulk-action`).addClass('d-none');
     }
})


function handleAjaxError(error) {
    
    var message = 'Something went wrong. Please provide valid data and try again';


    if(error && error.responseJSON){   
        
        if(error?.responseJSON?.errors){
            for (let i in error.responseJSON.errors) {
                toastr(error.responseJSON.errors[i][0],'danger')
            }
        }
        else{
            if((error?.responseJSON?.message)){

                toastr(error.responseJSON.message,'danger')
            }
            else{

                if(error?.responseJSON?.error)  message = error?.responseJSON?.error ;                
                toastr( message,'danger')
            }
        }
    }
    else{


        if(error.message){
            message = error.message
        }else if(error.statusText){
            message = error.statusText
        }
        toastr(error.message,'danger')

    }
   
}









