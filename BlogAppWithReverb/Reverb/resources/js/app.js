import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.Echo.channel('blogs').listen('.blog.created', (event) => {
    console.log('New Blog Created:', event);

    const loggedInUserId = document.querySelector("meta[name='user-id']")?.getAttribute("content");
    const loggedInUserIdNumber = Number(loggedInUserId);
    const eventUserId = event.user?.id ? Number(event.user.id) : null;

    if (eventUserId !== null && eventUserId === loggedInUserIdNumber) {
        console.log("Skipping notification for the blog author.");
        return;
    }

    let blogList = document.getElementById("blog-list");
    if (blogList) {
        let newBlog = document.createElement("div");
        newBlog.classList.add("bg-white", "shadow-lg", "rounded-lg", "overflow-hidden", "blog-item", "slide-in");
        newBlog.id = `blog-${event.id}`;

        newBlog.innerHTML = `
            <div class="p-4">
                <h4 class="text-lg font-semibold text-gray-900">${event.title}</h4>
                <p class="text-sm text-gray-600">
                    By <span class="font-semibold">${event.user?.name ?? 'Unknown Author'}</span>
                    on ${new Date(event.created_at).toLocaleDateString("en-US", { month: 'short', day: '2-digit', year: 'numeric' })}.
                </p>
                <p class="text-gray-700 mt-2">${event.content.substring(0, 100)}...</p>
                <a href="/blog" class="inline-block mt-3 text-blue-500 font-semibold hover:underline">Read More</a>
            </div>`;

        blogList.insertBefore(newBlog, blogList.firstChild);

         setTimeout(() => {
            newBlog.classList.remove("slide-in");
        }, 500);
    }

     if (event.title && event.user?.name) {
        let notificationContainer = document.getElementById("notification-container");
        let notification = document.createElement("div");

        notification.classList.add(
            "bg-green-500", "text-white", "p-2", "rounded-lg", "shadow-md",
            "fade-in", "flex", "items-center", "gap-2", "text-sm", "font-semibold"
        );

        notification.innerHTML = `
            <span>📝 New Blog:</span> <span>${event.title} by ${event.user.name}</span>
        `;

        notificationContainer.appendChild(notification);

        // Remove notification after 5 seconds
        setTimeout(() => {
            notification.classList.add("fade-out");
            setTimeout(() => {
                notification.remove();
            }, 500);
        }, 8000);
    }
});



window.Echo.channel('blogs').listen('BlogDeleted', (event) => {
    console.log('New Blog Created:', event.blogId);
    let blogItem = document.getElementById('blog-'+event.blogId);

    if(blogItem){
        blogItem.classList.add("slide-out");

        setTimeout(() => {
             blogItem.remove();
            
        }, 1000);
    }

});


window.Echo.channel('blogs').listen('.blog.updated', (event) => {
    console.log('blog updated:', event.blogId);
    let blogItem = document.getElementById('blog-'+event.id);

    if(blogItem){
        blogItem.classList.add("highlight-update");
        blogItem.querySelector("h4").textContent = event.title;
        
        blogItem.querySelector("p:nth-of-type(2)").textContent = event.content;
        setTimeout(() => {
             blogItem.classList.remove("highlight-update");
            
        }, 1000);
    }

});