package gobiernofacil.tuevaluas.index

import io.gatling.core.Predef._
import io.gatling.http.Predef._
import scala.concurrent.duration._

class TuEvaluasSimulation extends Simulation {
  val domain = "http://tuevaluas.testing.kaltia.org"
  val httpConf = http 
      .baseURL(domain)
      .acceptHeader("text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8") // 6
      .doNotTrackHeader("1")
      .acceptLanguageHeader("es-MX,en;q=0.5")
      .acceptEncodingHeader("gzip, deflate")
      .userAgentHeader("Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0")

  val scn = scenario("Tu Evaluas Simulation")
      .exec(http("Load index")
          .get("/"))
          .pause(3)
      .exec(http("Load about")
          .get("/que-es"))
          .pause(3)
      .exec(http("FAQ")
          .get("/preguntas-frecuentes"))
          .pause(3)
      .exec(http("Results")
          .get("/resultados"))

  setUp(
      scn.inject(atOnceUsers(15))
        ).protocols(httpConf)
}
