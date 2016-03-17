// AGENTES DE INNOVACIÓN - TÚ EVALÚAS APP CREATOR
// date     : 07/04/2015
// @package : agentes
// @file    : main.admin.js
// @version : 2.0.0
// @author  : Gobierno fácil <howdy@gobiernofacil.com>
// @url     : http://gobiernofacil.com

require.config({
  baseUrl : BASE_PATH  + "/js",
  paths : {
    jquery     : 'bower_components/jquery/dist/jquery.min',
    backbone   : "bower_components/backbone/backbone",
    underscore : "bower_components/underscore/underscore-min",
    text       : "bower_components/requirejs-text/text",
    velocity   : 'bower_components/velocity/velocity.min',
    d3         : 'bower_components/d3/d3.min',
    "jquery-validation" : "bower_components/jquery-validation/dist/jquery.validate.min"
  },
  shim : {
    backbone : {
      deps    : ["jquery", "underscore"],
      exports : "Backbone"
    },
    "jquery-validation" : {
      deps : ["jquery"]
    }
  }
});

 var app;


require(['controller.admin'], function(controller){ 
  app = new controller();
});
