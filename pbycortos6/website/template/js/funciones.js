// <![CDATA[
$(document).ready(
    function() {
	// opacity
	function opacity(element, value) {
	    var value_noie = value / 100;
	    $(element).css('filter', 'alpha(opacity=' + value + ')');
	    $(element).css('-moz-opacity', value_noie);
	    $(element).css('-khtml-opacity', value_noie);
	    $(element).css('opacity',value_noie);
	}

	// center horizontally
	function centerHoriz(lo_que) {
	    var x = parseFloat($(window).width()) / 2 - parseFloat($(lo_que).width()) / 2;
	    var y = $(window).scrollTop() + $(window).height() / 2 - parseFloat($(lo_que).height()) / 2;
	    x = x + 'px';
	    y = y + 'px';
	    $(lo_que).css({
		'left': x,
		'top': y
	    });
	}

	// center vertically
	function centerVert(lo_que) {
	    var y = $(window).scrollTop() + $(window).height() / 2 - parseFloat($(lo_que).height()) / 2;
	    $(lo_que).css({
		'top': y
	    });
	}

	// no dotted outline for IE in As
	if ($.browser.msie) {
	    $('a').focus(
		function() {
		    $(this).blur()
		}
		);
	}

	// image load
	function loadImg(sID, sURL) {
	    $(sID).unbind("load");
	    $(sID).bind("load", function() {
		$(this).fadeIn();
	    } )
	    $(sID).stop(true, true).fadeOut("normal", function () {
		$(sID).attr('src', sURL);
	    } );
	}

	// clear inputs
	var input_values = Array();
	$('input[type=text]').each(
	    function() {
		input_values[$('input[type=text]').index(this)] = $(this).val();
	    }
	    );
	$('input[type=text]').focus(
	    function() {
		if($(this).val() == input_values[$('input[type=text]').index(this)]) {
		    $(this).val('');
		}
	    }
	    );
	$('input[type=text]').blur(
	    function() {
		if($(this).val() == '') {
		    $(this).val(input_values[$('input[type=text]').index(this)]);
		}
	    }
	    );
	// END DEFAULT //
	
	// efecto en jurados
	$('a.more').toggle(function(){
            console.log('si');
		$(this).parent().find('div.hidden').slideDown();
	}, function() {
            console.log('simmm');
		$(this).parent().find('div.hidden').slideUp();
	});

	//fotos prensa
	$("a[rel='galeria']").colorbox();
    }
    );
// ]]>