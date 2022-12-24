const notificationsCountElem = document.querySelector("span[data-count]");
let notificationsCount = +notificationsCountElem.innerHTML;
const notifications = document.querySelector(".notifications");

// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;
const pusher = new Pusher("8e7583b608d0a841ba85", {
    cluster: "mt1",
});

const channel = pusher.subscribe("new-notification");

channel.bind("new-notification", function (data) {
    console.log("############ => " + data);
    notificationsCount++;
    notificationsCountElem.innerHTML = notificationsCount;
    // const notifyParagraph = document.createElement("p");
    // notifyParagraph.innerHTML = data.comment;
    // notifications.appendChild(notifyParagraph);
});
