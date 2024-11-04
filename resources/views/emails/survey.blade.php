<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Email</title>
</head>
<body>
    <p>Hi {{ $clientContactName }},</p>

    <p>
        Improvement is an ongoing process. In the wake of improving our services to our customers, 
        IDS Infotech shares Customer Satisfaction Survey on a periodic basis to be filled out by its esteemed Customers. 
        Please click on the "Take Survey" button below to fill the form.
    </p>

    <p>
        We appreciate your time and inputs to help us serve you better.
    </p>    
        <a href="http://127.0.0.1:8000/customersatifactionsurvey/{{$token}}" target="_blank" style="border:1px solid blue; background-color:blue;border-radius:5px;padding:5px;color:white;text-decoration:none;">Take Survey</a>
    

    <p>The survey parameters (How it works?):</p>
    <ul>
        <li>Points 0-2: Poor</li>
        <li>Points 3-6: Bad</li>
        <li>Points 7-8: Neutral</li>
        <li>Point 9: Good</li>
        <li>Point 10: Excellent</li>
        <li>NA: Not Applicable</li>
    </ul>

    <p>
        Looking forward to serving you better.
        <br>
        Regards,
        <br>
        {{ $idsLeadManager }}
    </p>
</body>
</html>
