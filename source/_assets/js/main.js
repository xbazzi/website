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

// Image enlargement functionality
function initImageEnlargement() {
    // Create modal overlay
    const modal = document.createElement('div');
    modal.id = 'image-modal';
    modal.className = 'image-modal';
    modal.innerHTML = `
        <div class="image-modal-backdrop"></div>
        <button class="image-modal-close" aria-label="Close image">&times;</button>
        <img class="image-modal-content" src="" alt="">
    `;
    document.body.appendChild(modal);

    const modalImg = modal.querySelector('.image-modal-content');
    const closeBtn = modal.querySelector('.image-modal-close');
    const backdrop = modal.querySelector('.image-modal-backdrop');

    // Find all images in prose content (blog posts and projects)
    const contentImages = document.querySelectorAll('.prose img, .prose-invert img');
    
    contentImages.forEach(img => {
        // Add click cursor style
        img.style.cursor = 'zoom-in';
        
        // Add click event
        img.addEventListener('click', function() {
            modalImg.src = this.src;
            modalImg.alt = this.alt;
            modal.classList.add('active');
            document.body.style.overflow = 'hidden'; // Prevent scrolling
        });
    });

    // Close modal functions
    function closeModal() {
        modal.classList.remove('active');
        document.body.style.overflow = ''; // Restore scrolling
    }

    closeBtn.addEventListener('click', closeModal);
    backdrop.addEventListener('click', closeModal);
    
    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeModal();
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    console.log("Loading RSS feed")
    displayRSSFeed()
    initImageEnlargement()
});
