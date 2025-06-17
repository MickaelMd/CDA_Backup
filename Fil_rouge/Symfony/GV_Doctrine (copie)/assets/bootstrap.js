// assets/bootstrap.js

import { Application } from "@hotwired/stimulus";
import HelloController from "./controllers/hello_controller.js"; // à adapter si besoin

const application = Application.start();
application.register("hello", HelloController);
