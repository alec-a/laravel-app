/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
	
	$('.wltask ').click(function(){
			var tm = new taskModal;
			tm.getData($(this).data('wlt'));
		});
});

