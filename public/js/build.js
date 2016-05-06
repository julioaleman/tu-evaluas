/*
({
    baseUrl: ".",
    paths: {
        jquery: "some/other/jquery"
    },
    name: "main",
    out: "main-built.js"
})
*/

({
  baseUrl : '.',
  paths : {
  	//requireLib : 'bower_components/requirejs/require',
    jquery     : 'bower_components/jquery/dist/jquery',
    underscore : "bower_components/underscore/underscore",
    backbone   : "bower_components/backbone/backbone",
    text       : "bower_components/requirejs-text/text"
  },
  shim : {
    backbone : {
      deps    : ["jquery", "underscore"],
      exports : "Backbone"
    }
  },
  name : "main",
  out : "main-built.js"
})