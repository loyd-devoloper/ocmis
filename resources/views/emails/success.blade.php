<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></link>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 py-10">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4">Dear {{ $customerName }},</h1>
        <p class="mb-4">Thank you for your recent payment! We have received your payment for the columbarium niche and have successfully updated your account.</p>

        <h2 class="text-xl font-semibold mb-2">Payment Details:</h2>
        <ul class="list-disc list-inside mb-4">
            <li><strong>Payment Method:</strong> {{ $paymentMethod }}</li>
            <li><strong>Amount Paid:</strong> {{ $paymentAmount }}</li>
            <li><strong>Transaction ID:</strong> {{ $transactionId }}</li>
            <li><strong>Date of Payment:</strong> {{ $paymentDate }}</li>
        </ul>

        <h2 class="text-xl font-semibold mb-2">Reservation Status:</h2>
        <p class="mb-4">You can view your reservation details in your account or contact us for further assistance.</p>

        <p class="mb-4">Thank you for your attention to this matter, and for choosing OCMIS.</p>

        <p class="mt-8">Best regards,</p>
        <p>OCMIS Team</p>
    </div>
</body>
</html>
