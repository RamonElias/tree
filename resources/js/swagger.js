import SwaggerUI from "swagger-ui";
import "swagger-ui/dist/swagger-ui.css";

SwaggerUI({
  dom_id: "#swagger-api",
  url: "http://localhost:12376/api.yaml",
});
