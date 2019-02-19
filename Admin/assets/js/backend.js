$(document).ready(function () {
    'use strict';
    //Hide placeholder on form focus
    $('[placeholder]').focus(function () {
       $(this).attr('data-text', $(this).attr('placeholder'));
       $(this).attr('placeholder' , '');
    }).blur(function () {
       $(this).attr('placeholder' ,$(this).attr('data-text'));
    });
    //Add Asterisk on Required Field
    $('input').each(function () {
        if ($(this).attr('required')==='required'){
            $(this).after('<span class="asterisk">*</span>')
        }
    });
    //Convert password field to text field on hover
    var passfield=$('.password');
    $('.show-pass').hover(function () {
        passfield.attr('type','text');
    },function () {
        passfield.attr('type','password');
    });
    //Confirmation Message on Button
    $('.confirm').click(function () {
       return confirm('Are You sure To delete user?')
    });
});