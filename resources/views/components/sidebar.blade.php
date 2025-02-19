<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="sidebar" style="width: 200px; height: 100%; position: fixed; left: 0; top: 0; background-color: #f8f9fa; padding: 20px;">
        <h2>Sidebar</h2>
        <ul style="list-style-type: none; padding: 0;">
            <li><a href="#home">Home</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#clients">Clients</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </div>
    <nav style="width: 100%; height: 50px; background-color: #343a40; color: white; display: flex; align-items: center; padding: 0 20px; position: fixed; top: 0; left: 200px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
        <a href="#home" style="color: white; text-decoration: none; margin-right: 20px;">Home</a>
        <a href="#services" style="color: white; text-decoration: none; margin-right: 20px;">Services</a>
        <a href="#clients" style="color: white; text-decoration: none; margin-right: 20px;">Clients</a>
        <a href="#contact" style="color: white; text-decoration: none;">Contact</a>
    </nav>
    <div style="margin-left: 215px; padding: 20px;">
        {{ $slot }}
    </div>
</body>
</html>