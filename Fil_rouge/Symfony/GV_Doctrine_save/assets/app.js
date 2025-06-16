import "./bootstrap.js";
import "./styles/app.css";

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
