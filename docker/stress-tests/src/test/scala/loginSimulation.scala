package gobiernofacil.tuevaluas.login

import io.gatling.core.Predef._
import io.gatling.http.Predef._
import scala.concurrent.duration._

class TuEvaluasLoginSimulation extends Simulation {
  val domain = "http://tuevaluas.testing.kaltia.org"
  val httpConf = http 
      .baseURL(domain)
      .acceptHeader("text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8") // 6
      .doNotTrackHeader("1")
      .acceptLanguageHeader("es-MX,en;q=0.5")
      .acceptEncodingHeader("gzip, deflate")
      .userAgentHeader("Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0")

  val scn = scenario("Tu Evaluas Simulation")
      .exec(http("Load login")
          .get("/login")
          .check(css("[name=_token]", "value").saveAs("auth_token")))
          .pause(4)
      .exec(http("Login User")
          .post("/login")
          .formParam("email", "howdy@gobiernofacil.com")
          .formParam("password", "OlgaBreeskin")
          .formParam("_token", "${auth_token}"))
          .pause(5)
      .exec(http("Log out")
          .get("/logout")
          .check(status.is(200)))

  setUp(
      scn.inject(atOnceUsers(5))
        ).protocols(httpConf)
}

