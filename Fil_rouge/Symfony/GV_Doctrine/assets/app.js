import "./bootstrap.js";
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import "./styles/app.css";

console.log("This log comes from assets/app.js - welcome to AssetMapper! 🎉");

document.addEventListener("DOMContentLoaded", () => {
  const notifications = document.querySelectorAll(".notification");

  const delayBetween = 1000;
  const baseDisplayTime = 3000;

  notifications.forEach((notification, index) => {
    setTimeout(() => {
      notification.classList.add("show");
    }, 100 * index);

    const totalDelay = baseDisplayTime + index * delayBetween;
    setTimeout(() => {
      notification.classList.remove("show");
      notification.style.transform = "translateY(-20px)";
      setTimeout(() => notification.remove(), 500);
    }, totalDelay);

    notification.addEventListener("click", () => {
      notification.classList.remove("show");
      notification.style.transform = "translateY(-20px)";
      setTimeout(() => notification.remove(), 500);
    });
  });
});
