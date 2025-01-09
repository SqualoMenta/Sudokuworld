<?php

include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");

if (!isUserLoggedIn()) {
    header("Location: login.php");
}
include("../includes/header.php");
?>

<script>
    function loadContent(page) {
        const mainContent = document.getElementById('main-content');
        mainContent.innerHTML = '<div class="loader">Loading...</div>';

        fetch(page)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.text();
            })
            .then(data => {
                mainContent.innerHTML = data;
            })
            .catch(error => {
                mainContent.innerHTML = '<div class="loader">Error loading page: ' + error.message + '</div>';
            });
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Load default content (e.g., profile.php) on page load
        loadContent('previous_orders.php');

        // Attach event listeners to sidebar links
        const links = document.querySelectorAll('.sidebar a');
        links.forEach(link => {
            if(link.getAttribute('href') !== 'cart.php' && link.getAttribute('href') !== 'wishlist.php'){   
                link.addEventListener('click', event => {
                    event.preventDefault();
                    loadContent(event.target.getAttribute('href'));
                });                
            }
        });
    });
</script>
    <div class="sidebar">
        <a href="info-user.php">User Info</a>
        <a href="previous_orders.php">Previous Orders</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="main-content" id="main-content">
        <!-- Content from the selected page will be loaded here -->
    </div>


<?php
include("../includes/footer.php");
?>