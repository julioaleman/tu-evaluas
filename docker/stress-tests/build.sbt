name := "Test site"

enablePlugins(GatlingPlugin)

libraryDependencies += "io.gatling.highcharts" % "gatling-charts-highcharts" % "2.2.0" 
libraryDependencies += "io.gatling.highcharts" % "gatling-charts-highcharts" % "2.2.0" % "test"
libraryDependencies += "io.gatling"            % "gatling-test-framework"    % "2.2.0" % "test"

