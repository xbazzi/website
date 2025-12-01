import { codeToHtml } from "shiki";
async function fetchRSSFeed(url) {
    try {
        const response = await fetch(url);
        const data = await response.text();
        return data;
    } catch (error) {
        console.error("Failed to fetch RSS feed:", error);
        return null;
    }
}

function parseRSSFeed(feedXML) {
    const parser = new DOMParser();
    const xmlDoc = parser.parseFromString(feedXML, "text/xml");
    const items = xmlDoc.querySelectorAll("item");
    let html = "<ul>";

    for (let i = 0; i < Math.min(items.length, 8); i++) {
        const title = items[i].querySelector("title").textContent;
        const link = items[i].querySelector("link").textContent;
        html += `<a href="${link}" target="_blank">${title}</a><br><br>`;

    };

    html += "</ul>";
    return html;
}

async function displayRSSFeed() {
    const url = "https://1pro71t329.execute-api.us-east-1.amazonaws.com/darknet/rss"
    const rssData = await fetchRSSFeed(url);

    if (rssData) {
        const feedHTML = parseRSSFeed(rssData);
        document.getElementById("rss-feed").innerHTML = feedHTML;
    } else {
        document.getElementById("rss-feed").innerHTML = "Failed to load RSS feed.";
    }
}

document.addEventListener('DOMContentLoaded', function () {
    console.log("Loading RSS feed")
    displayRSSFeed()
});
