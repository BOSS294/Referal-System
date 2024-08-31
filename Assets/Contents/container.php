<div class="container">
    <h2>Enter Referral Code</h2>
    <form id="referralForm">
        <div class="input-box">
            <input type="text" name="username" required>
            <label>Enter Your Name</label>
        </div>
        <br>
        <div class="input-box">
            <input type="text" name="referral_code" required>
            <label>Enter Referral Code</label>
        </div>
        <button type="submit" class="submit-btn">Submit</button>
    </form>
    <div class="small-container">
        Apply a referral code to get exciting rewards. <br><a href="#" style="color: #BBDEFB;">Know more...</a>
    </div>
</div>

<!-- Include PopupPro Script and Google Icons -->
<script src="Assets/JS/popup-pro.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

<script>
    document.getElementById('referralForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission

        const formData = new FormData(event.target);
        const username = formData.get('username');
        const referralCode = formData.get('referral_code');

        fetch('Assets/Processors/process_referral.php', {
            method: 'POST',
            body: JSON.stringify({ username, referralCode }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                PopupPro.show({
                    title: "Success!",
                    message: "Referral code applied successfully.",
                    backgroundColor: "#4CAF50",
                    textColor: "#FFFFFF",
                    icon: "check_circle",
                    animationDuration: 500
                });
            } else {
                PopupPro.show({
                    title: "Invalid Code!",
                    message: "The referral code you entered is invalid.",
                    backgroundColor: "#F44336",
                    textColor: "#FFFFFF",
                    icon: "error",
                    animationDuration: 500
                });
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>
