/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function() {

  var currentliwidth = jQuery('.nav-menu li').width();
  jQuery('.nav-menu li').css('height', currentliwidth);
  jQuery('.nav-menu li a').css('bottom', currentliwidth / (-211 / 140));

// show / hise the category description in home page
  jQuery('.menu-item').mouseover(function() {
    //jQuery(this).next('.menu-item a').animate({bottom: '0px'}, 500);
    jQuery(this).find('a').animate({bottom: '0px'}, 500);
  });
  jQuery('.menu-item').mouseleave(function() {
    //jQuery(this).next('.menu-item a').animate({bottom: '0px'}, 500);
    jQuery(this).find('a').animate({bottom: currentliwidth / (-211 / 140)}, 500);
  });

  jQuery(window).resize(function() {
    var currentliwidth = jQuery('.nav-menu li').width();
    jQuery('.nav-menu li').css('height', currentliwidth);
    jQuery('.nav-menu li a').css('bottom', currentliwidth / (-211 / 140));

// show / hise the category description in home page
    


  });


//remove the link on level 2 categories in the sidebar

  //jQuery('.left > ul > li > a').contents().unwrap();
 

//show / hide the content of level 2 categories in sidebar
// jQuery('.left > ul > li ul').hide();
 /* jQuery('.left > ul > li').click(function() {

    jQuery(this).find('ul').slideToggle(250);
  });
*/
/*
jQuery('.left > ul > li').mouseover(function() {
    //jQuery(this).next('.menu-item a').animate({bottom: '0px'}, 500);
    jQuery(this).find('ul').show(250);
    
  });
  
  jQuery('.left > ul > li').mouseleave(function() {
    //jQuery(this).next('.menu-item a').animate({bottom: '0px'}, 500);
     jQuery(this).find('ul').hide(250);
  });
*/
  //open close the search bar

  jQuery('.open-search').click(function() {
    jQuery('.search-box').slideToggle(250);
  });



});