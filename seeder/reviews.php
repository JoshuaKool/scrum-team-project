<?php

$stmt = $pdo->prepare("INSERT INTO `reviews` (rating, review, house_id, reviewer_id)
    VALUES (:rating, :review, :house_id, :reviewer_id)");

$data = [
    [8.2, "Beautiful house with amazing views!", 1, 1],
    [7.5, "Nice location with beautiful scenery.", 1, 2],
    [9.0, "Excellent service and beautiful house.", 1, 3],
    [6.5, "Cozy and comfortable, perfect for families.", 2, 4],
    [7.0, "Lovely house with a great view.", 2, 5],
    [8.5, "A wonderful experience in a cozy house.", 2, 6],
    [9.0, "Spacious and luxurious, exceeded expectations.", 3, 7],
    [8.8, "Modern and stylish, very comfortable.", 3, 8],
    [9.1, "Fantastic amenities and great service.", 3, 9],
    [7.8, "Great location, close to everything.", 4, 10],
    [8.0, "Convenient and comfortable, enjoyed our stay.", 4, 1],
    [7.9, "Nice house with friendly hosts.", 4, 2],
    [7.0, "Charming and quaint, loved the atmosphere.", 5, 3],
    [7.4, "Cozy and charming, felt like home.", 5, 4],
    [7.6, "Great experience in a quaint house.", 5, 5],
    [9.5, "Absolutely stunning, a dream come true!", 6, 6],
    [9.2, "Luxurious and comfortable, highly recommended.", 6, 7],
    [9.4, "Exceeded all expectations, wonderful stay.", 6, 8],
    [8.9, "Modern amenities and stylish decor.", 7, 9],
    [8.7, "Well-maintained and very comfortable.", 7, 10],
    [9.1, "Fantastic location and great service.", 7, 1],
    [6.3, "Quiet and peaceful retreat, ideal for relaxation.", 8, 2],
    [6.8, "Nice and calm place, good for rest.", 8, 3],
    [6.5, "Good value and peaceful environment.", 8, 4],
    [8.7, "Historic charm with contemporary comforts.", 9, 5],
    [8.5, "Unique blend of old and new.", 9, 6],
    [8.9, "Charming and well-preserved.", 9, 7],
    [7.2, "Unique architecture and lovely surroundings.", 10, 8],
    [7.5, "Beautiful design and setting.", 10, 9],
    [7.3, "Interesting place with character.", 10, 10],
    [9.3, "Incredible stay, would highly recommend!", 11, 1],
    [9.0, "Fantastic experience, will come again.", 11, 2],
    [9.2, "Memorable stay, wonderful service.", 11, 3],
    [8.4, "Comfortable and clean, felt like home.", 12, 4],
    [8.6, "Very clean and homely.", 12, 5],
    [8.2, "Comfortable stay, great for families.", 12, 6],
    [7.5, "Beautiful setting, perfect for nature lovers.", 13, 7],
    [7.3, "Nature at its best, very serene.", 13, 8],
    [7.6, "Perfect getaway for nature enthusiasts.", 13, 9],
    [8.0, "Excellent location, close to attractions.", 14, 10],
    [8.2, "Convenient location and comfortable stay.", 14, 1],
    [7.9, "Great spot, close to everything.", 14, 2],
    [7.9, "Well-maintained and spacious, great for groups.", 15, 3],
    [8.1, "Spacious and perfect for large groups.", 15, 4],
    [7.8, "Good for group stays, very spacious.", 15, 5],
    [9.1, "Outstanding service and amenities.", 16, 6],
    [9.3, "Top-notch service and very comfortable.", 16, 7],
    [9.0, "Great service and amenities.", 16, 8],
    [8.6, "Cozy atmosphere, ideal for a romantic getaway.", 17, 9],
    [8.7, "Romantic setting, very cozy.", 17, 10],
    [8.5, "Perfect for couples, very cozy.", 17, 1],
    [6.8, "Good value for money, enjoyable stay.", 18, 2],
    [6.9, "Affordable and pleasant stay.", 18, 3],
    [6.7, "Worth the price, nice stay.", 18, 4],
    [7.3, "Unique experience, loved every moment.", 19, 5],
    [7.2, "Different and enjoyable experience.", 19, 6],
    [7.5, "Interesting and unique stay.", 19, 7],
    [8.3, "Impressive architecture and beautiful surroundings.", 20, 8],
    [8.2, "Lovely design and environment.", 20, 9],
    [8.4, "Beautifully designed and great location.", 20, 10],
    [8.1, "Relaxing ambiance, perfect for unwinding.", 21, 1],
    [8.0, "Very relaxing and calming.", 21, 2],
    [8.2, "Great place to unwind and relax.", 21, 3],
    [7.7, "Friendly hosts and comfortable accommodations.", 22, 4],
    [7.6, "Very friendly hosts, comfortable stay.", 22, 5],
    [7.8, "Nice hosts and cozy accommodations.", 22, 6],
    [8.8, "Memorable stay, will definitely return!", 23, 7],
    [8.9, "Unforgettable experience, great place.", 23, 8],
    [8.7, "Fantastic stay, highly recommend.", 23, 9],
    [7.6, "Lovely views and peaceful environment.", 24, 10],
    [7.8, "Great views and very peaceful.", 24, 1],
    [7.5, "Beautiful scenery and quiet area.", 24, 2],
    [9.2, "Exceptional hospitality and luxurious amenities.", 25, 3],
    [9.4, "Amazing hospitality and very luxurious.", 25, 4],
    [9.1, "Great service and luxury amenities.", 25, 5],
    [8.5, "Well-appointed and spacious, felt like a palace.", 26, 6],
    [8.6, "Very spacious and well-equipped.", 26, 7],
    [8.4, "Comfortable and spacious stay.", 26, 8],
    [7.4, "Quirky and fun, enjoyed every aspect.", 27, 9],
    [7.3, "Unique and fun experience.", 27, 10],
    [7.5, "Very quirky and enjoyable.", 27, 1],
    [8.0, "Serene and picturesque, a hidden gem.", 28, 2],
    [8.2, "Beautiful and serene location.", 28, 3],
    [7.9, "Very calm and scenic place.", 28, 4],
    [7.1, "Cozy and inviting, perfect for a getaway.", 29, 5],
    [7.2, "Warm and inviting place.", 29, 6],
    [7.0, "Cozy spot for a relaxing getaway.", 29, 7],
    [9.4, "Absolutely stunning property, exceeded expectations!", 30, 8],
    [9.5, "Amazing property, highly recommend.", 30, 9],
    [9.3, "Exceeded all expectations, wonderful place.", 30, 10],
    [8.3, "Great value and very comfortable.", 31, 1],
    [8.5, "Affordable and cozy.", 31, 2],
    [8.2, "Good value for a comfortable stay.", 31, 3],
    [7.7, "Friendly staff and comfortable room.", 32, 4],
    [7.8, "Nice staff and clean room.", 32, 5],
    [7.6, "Good service and comfortable stay.", 32, 6],
    [8.9, "Excellent service and amenities.", 33, 7],
    [9.0, "Top-notch service and facilities.", 33, 8],
    [8.8, "Great amenities and service.", 33, 9],
    [7.2, "Quiet and peaceful, great for relaxation.", 34, 10],
    [7.3, "Very calm and serene.", 34, 1],
    [7.1, "Peaceful place to relax.", 34, 2],
    [8.1, "Beautiful surroundings and cozy.", 35, 3],
    [8.2, "Lovely environment and comfortable.", 35, 4],
    [8.0, "Great surroundings and cozy place.", 35, 5],
    [7.5, "Nice and clean, good service.", 36, 6],
    [7.4, "Very clean and good service.", 36, 7],
    [7.6, "Clean place with good service.", 36, 8],
    [9.1, "Fantastic experience, highly recommend.", 37, 9],
    [9.0, "Wonderful stay, great service.", 37, 10],
    [9.2, "Amazing place, will come again.", 37, 1],
    [8.7, "Very comfortable and cozy.", 38, 2],
    [8.6, "Cozy and very comfortable.", 38, 3],
    [8.8, "Comfortable stay, very cozy.", 38, 4],
    [7.0, "Good value, comfortable stay.", 39, 5],
    [7.1, "Affordable and comfortable.", 39, 6],
    [6.9, "Worth the price, nice stay.", 39, 7],
    [8.4, "Great location and comfortable.", 40, 8],
    [8.3, "Convenient location and nice stay.", 40, 9],
    [8.5, "Comfortable stay, great location.", 40, 10],
    [7.8, "Nice hosts and cozy place.", 41, 1],
    [7.9, "Friendly hosts and comfortable stay.", 41, 2],
    [7.7, "Good hosts and cozy accommodations.", 41, 3],
    [9.2, "Outstanding service, very comfortable.", 42, 4],
    [9.1, "Great service and very cozy.", 42, 5],
    [9.3, "Fantastic service and amenities.", 42, 6],
    [8.5, "Good value and clean.", 43, 7],
    [8.6, "Affordable and very clean.", 43, 8],
    [8.4, "Clean and comfortable stay.", 43, 9],
    [7.4, "Nice and quiet, very relaxing.", 44, 10],
    [7.5, "Very relaxing and calm place.", 44, 1],
    [7.3, "Quiet spot for relaxation.", 44, 2],
    [8.0, "Nice location and cozy place.", 45, 3],
    [8.1, "Cozy place, good location.", 45, 4],
    [7.9, "Comfortable and good location.", 45, 5],
    [8.7, "Great service and very cozy.", 46, 6],
    [8.6, "Excellent service and comfortable.", 46, 7],
    [8.8, "Fantastic service and amenities.", 46, 8],
    [7.2, "Nice and clean, good value.", 47, 9],
    [7.1, "Affordable and very clean.", 47, 10],
    [7.3, "Clean and comfortable stay.", 47, 1],
    [9.0, "Fantastic place, highly recommend.", 48, 2],
    [9.1, "Amazing experience, great service.", 48, 3],
    [8.9, "Wonderful stay, will come again.", 48, 4],
    [7.5, "Nice and quiet, great stay.", 49, 5],
    [7.6, "Calm and very relaxing.", 49, 6],
    [7.4, "Good spot for relaxation.", 49, 7],
    [8.3, "Beautiful place, very cozy.", 50, 8],
    [8.4, "Lovely and comfortable stay.", 50, 9],
    [8.2, "Nice environment and cozy place.", 50, 10],
    [7.0, "Affordable and comfortable.", 51, 1],
    [7.1, "Good value for money.", 51, 2],
    [6.9, "Comfortable stay, worth the price.", 51, 3],
    [8.5, "Nice and cozy, great service.", 52, 4],
    [8.6, "Good service and very cozy.", 52, 5],
    [8.4, "Comfortable stay and good service.", 52, 6],
    [7.3, "Nice location and comfortable.", 53, 7],
    [7.2, "Comfortable stay, good location.", 53, 8],
    [7.4, "Great location and cozy place.", 53, 9],
    [8.8, "Fantastic experience, highly recommend.", 54, 10],
    [8.9, "Wonderful place, great service.", 54, 1],
    [8.7, "Great stay, will come again.", 54, 2],
    [7.8, "Nice hosts and very comfortable.", 55, 3],
    [7.9, "Friendly hosts and cozy place.", 55, 4],
    [7.7, "Comfortable stay and nice hosts.", 55, 5],
    [9.1, "Outstanding service, very cozy.", 56, 6],
    [9.0, "Fantastic service and comfortable.", 56, 7],
    [9.2, "Great service and amenities.", 56, 8],
    [8.6, "Good value and very clean.", 57, 9],
    [8.5, "Affordable and clean stay.", 57, 10],
    [8.7, "Clean and comfortable stay.", 57, 1],
    [7.4, "Nice and quiet, good value.", 58, 2],
    [7.5, "Calm place, worth the price.", 58, 3],
    [7.3, "Quiet and very relaxing.", 58, 4],
    [8.0, "Nice place, very cozy.", 59, 5],
    [8.1, "Comfortable stay, good location.", 59, 6],
    [7.9, "Good value and comfortable.", 59, 7],
    [8.9, "Fantastic service and very cozy.", 60, 8],
    [9.0, "Great service and amenities.", 60, 9],
    [8.8, "Excellent service, very comfortable.", 60, 10],
    [7.2, "Good value and very clean.", 61, 1],
    [7.1, "Affordable and comfortable stay.", 61, 2],
    [7.3, "Clean and comfortable place.", 61, 3],
    [9.0, "Outstanding service, highly recommend.", 62, 4],
    [9.1, "Fantastic experience, great service.", 62, 5],
    [8.9, "Wonderful stay, very comfortable.", 62, 6],
    [7.5, "Nice and cozy, good value.", 63, 7],
    [7.6, "Comfortable and affordable.", 63, 8],
    [7.4, "Cozy place, worth the price.", 63, 9],
    [8.3, "Beautiful place, great service.", 64, 10],
    [8.4, "Lovely and very comfortable.", 64, 1],
    [8.2, "Nice environment and service.", 64, 2],
    [7.0, "Affordable and comfortable.", 65, 3],
    [7.1, "Good value and very clean.", 65, 4],
    [6.9, "Comfortable stay, worth the price.", 65, 5],
    [8.5, "Nice and cozy, good service.", 66, 6],
    [8.6, "Very cozy and comfortable.", 66, 7],
    [8.4, "Comfortable stay and great service.", 66, 8],
    [7.3, "Nice location and very cozy.", 67, 9],
    [7.2, "Comfortable stay, great location.", 67, 10],
    [7.4, "Good value and cozy place.", 67, 1],
    [8.8, "Fantastic experience, very cozy.", 68, 2],
    [8.9, "Great service and amenities.", 68, 3],
    [8.7, "Wonderful stay, highly recommend.", 68, 4],
    [7.8, "Nice hosts and very cozy.", 69, 5],
    [7.9, "Friendly hosts and comfortable stay.", 69, 6],
    [7.7, "Cozy place, great hosts.", 69, 7],
    [9.1, "Outstanding service, highly recommend.", 70, 8],
    [9.0, "Fantastic service and very comfortable.", 70, 9],
    [9.2, "Great amenities and service.", 70, 10],
    [8.6, "Good value and very clean.", 71, 1],
    [8.5, "Affordable and comfortable stay.", 71, 2],
    [8.7, "Clean and cozy place.", 71, 3],
    [7.4, "Nice and quiet, very relaxing.", 72, 4],
    [7.5, "Calm and worth the price.", 72, 5],
    [7.3, "Quiet and very comfortable.", 72, 6],
    [8.0, "Nice location, very cozy.", 73, 7],
    [8.1, "Comfortable stay and great location.", 73, 8],
    [7.9, "Good value and comfortable.", 73, 9],
    [8.9, "Fantastic service and very cozy.", 74, 10],
    [9.0, "Great service and amenities.", 74, 1],
    [8.8, "Wonderful stay, highly recommend.", 74, 2],
    [7.2, "Good value and very clean.", 75, 3],
    [7.1, "Affordable and comfortable stay.", 75, 4],
    [7.3, "Clean and cozy place.", 75, 5],
    [9.0, "Outstanding service, highly recommend.", 76, 6],
    [9.1, "Fantastic experience, great service.", 76, 7],
    [8.9, "Wonderful stay, very comfortable.", 76, 8],
    [7.5, "Nice and cozy, good value.", 77, 9],
    [7.6, "Comfortable and affordable.", 77, 10],
    [7.4, "Cozy place, worth the price.", 77, 1],
    [8.3, "Beautiful place, great service.", 78, 2],
    [8.4, "Lovely and very comfortable.", 78, 3],
    [8.2, "Nice environment and service.", 78, 4],
    [7.0, "Affordable and comfortable.", 79, 5],
    [7.1, "Good value and very clean.", 79, 6],
    [6.9, "Comfortable stay, worth the price.", 79, 7],
    [8.5, "Nice and cozy, good service.", 80, 8],
    [8.6, "Very cozy and comfortable.", 80, 9],
    [8.4, "Comfortable stay and great service.", 80, 10],
    [7.3, "Nice location and very cozy.", 81, 1],
    [7.2, "Comfortable stay, great location.", 81, 2],
    [7.4, "Good value and cozy place.", 81, 3],
];

foreach ($data as $entry) {
    $stmt->bindParam(':rating', $entry[0]);
    $stmt->bindParam(':review', $entry[1]);
    $stmt->bindParam(':house_id', $entry[2]);
    $stmt->bindParam(':reviewer_id', $entry[3]);
    
    $stmt->execute();
}
?>