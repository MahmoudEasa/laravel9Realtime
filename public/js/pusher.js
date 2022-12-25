const notifications = document.querySelectorAll(".notifications");
const notificationsCountElem = document.querySelector("span[data-count]");
const notificationsContents = document.querySelector(".notificationsContents");
let notificationsCount = +notificationsCountElem.innerHTML;
const ownerPost = notificationsCountElem.attributes.ownerPost.value;

const createComment = (comment, item, classAttr = "", hr = false) => {
    const notifyParagraph = `<p class="${classAttr}">${comment}</p>${
        hr ? "<hr>" : ""
    }`;

    item.innerHTML += notifyParagraph;
};

// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;
const pusher = new Pusher("8e7583b608d0a841ba85", {
    cluster: "mt1",
});

const channel = pusher.subscribe("new-notification");
channel.bind("new-notification", function (data) {
    if (data.ownerPost == ownerPost) {
        notificationsCount++;
        notificationsCountElem.innerHTML = notificationsCount;
        createComment(data.comment, notificationsContents, "py-3", true);
    }

    [...notifications].map((item) => {
        if (item.id == data.post_id) {
            createComment(data.comment, item, "py-3");
        }
    });
});
