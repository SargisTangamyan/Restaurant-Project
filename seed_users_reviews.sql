-- ============================================================
-- 1. FIX USERS: proper username, first_name, last_name
-- ============================================================

-- Users 11-13: name was stored in username column; extract to first/last
UPDATE users SET username = 'hadley_koepp',      first_name = 'Hadley',    last_name = 'Koepp'     WHERE id = 11;
UPDATE users SET username = 'zaria_crist',        first_name = 'Zaria',     last_name = 'Crist'     WHERE id = 12;
UPDATE users SET username = 'tremayne_ferry',     first_name = 'Tremayne',  last_name = 'Ferry'     WHERE id = 13;

-- User 14: admin account — clean up "Sargis1" first name and fix username
UPDATE users SET username = 'sargis_admin',       first_name = 'Sargis',    last_name = 'Tangamyan' WHERE id = 14;

-- Users 15-26: all NULL names — derive from email
UPDATE users SET username = 'testuser',           first_name = 'Test',      last_name = 'User'      WHERE id = 15;
UPDATE users SET username = 'test_one',           first_name = 'Test',      last_name = 'One'       WHERE id = 16;
UPDATE users SET username = 'user_one',           first_name = 'User',      last_name = 'One'       WHERE id = 17;
UPDATE users SET username = 'user_two',           first_name = 'User',      last_name = 'Two'       WHERE id = 18;
UPDATE users SET username = 'test_two',           first_name = 'Test',      last_name = 'Two'       WHERE id = 19;
UPDATE users SET username = 'user_three',         first_name = 'User',      last_name = 'Three'     WHERE id = 20;
UPDATE users SET username = 'newuser',            first_name = 'New',       last_name = 'User'      WHERE id = 21;
UPDATE users SET username = 'user21',             first_name = 'User',      last_name = 'TwentyOne' WHERE id = 22;
UPDATE users SET username = 'user31',             first_name = 'User',      last_name = 'ThirtyOne' WHERE id = 23;
UPDATE users SET username = 'user_four',          first_name = 'User',      last_name = 'Four'      WHERE id = 24;
UPDATE users SET username = 'sargis_t',           first_name = 'Sargis',    last_name = 'Tangamyan' WHERE id = 25;
UPDATE users SET username = 'rudik_t',            first_name = 'Rudik',     last_name = 'Tadevosyan'WHERE id = 26;

-- Users 27-32: name was stored in username column; extract to first/last
UPDATE users SET username = 'leonard_grant',      first_name = 'Leonard',   last_name = 'Grant'     WHERE id = 27;
UPDATE users SET username = 'hilario_emard',      first_name = 'Hilario',   last_name = 'Emard'     WHERE id = 28;
UPDATE users SET username = 'kenyatta_murray',    first_name = 'Kenyatta',  last_name = 'Murray'    WHERE id = 29;
UPDATE users SET username = 'margarete_jacobson', first_name = 'Margarete', last_name = 'Jacobson'  WHERE id = 30;
UPDATE users SET username = 'liliane_harris',     first_name = 'Liliane',   last_name = 'Harris'    WHERE id = 31;
UPDATE users SET username = 'dane_fadel',         first_name = 'Dane',      last_name = 'Fadel'     WHERE id = 32;


-- ============================================================
-- 2. INSERT DISH REVIEWS
-- Dishes: 23–42 (real-named dishes)
-- Each (user_id, dish_id) pair is unique per the table constraint
-- ============================================================

INSERT INTO dish_reviews (user_id, dish_id, rating, comment, created_at, updated_at) VALUES

-- Dish 23 – Coca-Cola
(13, 23, 4.0, 'Nice and cold, exactly what you would expect. Great alongside the food.', '2025-11-03 12:10:00', '2025-11-03 12:10:00'),
(23, 23, 3.5, 'Standard cola, well served with plenty of ice.', '2025-12-18 14:22:00', '2025-12-18 14:22:00'),

-- Dish 24 – Fresh Lemonade
(15, 24, 5.0, 'Perfectly balanced between sweet and tangy. So refreshing!', '2025-10-15 11:05:00', '2025-10-15 11:05:00'),
(25, 24, 4.5, 'The freshest lemonade I have had — clearly made with real lemons!', '2026-01-20 13:30:00', '2026-01-20 13:30:00'),

-- Dish 25 – Iced Coffee
(16, 25, 4.5, 'Great coffee flavour, chilled to perfection. A lovely pick-me-up.', '2025-11-22 09:45:00', '2025-11-22 09:45:00'),
(26, 25, 4.0, 'Strong and refreshing iced coffee, exactly what I needed.', '2026-02-07 10:15:00', '2026-02-07 10:15:00'),

-- Dish 26 – Orange Juice
(17, 26, 5.0, 'Freshly squeezed and full of natural flavour. Absolutely delicious!', '2025-10-28 08:30:00', '2025-10-28 08:30:00'),
(27, 26, 4.5, 'Fresh and natural — you can taste the quality of the oranges.', '2026-01-11 09:00:00', '2026-01-11 09:00:00'),

-- Dish 27 – Mineral Water
(18, 27, 4.0, 'Good quality sparkling water, perfectly chilled.', '2025-12-05 12:50:00', '2025-12-05 12:50:00'),
(28, 27, 3.5, 'Standard mineral water, clean and refreshing. Does the job perfectly.', '2026-03-01 13:10:00', '2026-03-01 13:10:00'),

-- Dish 28 – Bruschetta
(11, 28, 4.5, 'Crispy bread with perfectly seasoned fresh tomatoes — a fantastic starter.', '2025-10-20 18:15:00', '2025-10-20 18:15:00'),
(19, 28, 4.0, 'Great bruschetta, the fresh herbs really made it shine.', '2025-12-12 19:00:00', '2025-12-12 19:00:00'),
(32, 28, 3.5, 'Tasty appetizer, though I would have liked a bit more garlic.', '2026-04-02 17:45:00', '2026-04-02 17:45:00'),

-- Dish 29 – Garlic Butter Shrimp
(12, 29, 5.0, 'The garlic butter sauce was absolutely heavenly! Perfectly cooked shrimp.', '2025-10-25 20:00:00', '2025-10-25 20:00:00'),
(20, 29, 4.5, 'Juicy shrimp with a rich buttery sauce — will definitely order again.', '2025-11-30 19:30:00', '2025-11-30 19:30:00'),
(30, 29, 4.0, 'Flavourful and satisfying, pairs beautifully with crusty bread.', '2026-03-15 18:50:00', '2026-03-15 18:50:00'),

-- Dish 30 – Caesar Salad
(11, 30, 4.0, 'Crispy romaine and a well-balanced dressing — classic and satisfying.', '2025-11-08 13:20:00', '2025-11-08 13:20:00'),
(17, 30, 4.5, 'One of the best Caesar salads I have had. The anchovies were perfectly judged.', '2025-12-22 13:00:00', '2025-12-22 13:00:00'),
(27, 30, 3.5, 'Good salad overall, croutons were a bit soft but the dressing was great.', '2026-02-14 14:10:00', '2026-02-14 14:10:00'),

-- Dish 31 – Greek Salad
(12, 31, 5.0, 'Generous feta, fresh vegetables, and lovely olive oil. Completely authentic!', '2025-10-30 12:40:00', '2025-10-30 12:40:00'),
(21, 31, 4.0, 'Light, refreshing, and full of flavour. My go-to salad option.', '2026-01-05 13:55:00', '2026-01-05 13:55:00'),
(28, 31, 4.5, 'Excellent quality olives and feta. Tasted very fresh and authentic.', '2026-03-20 12:30:00', '2026-03-20 12:30:00'),

-- Dish 32 – Grilled Chicken with Vegetables
(13, 32, 4.5, 'Juicy grilled chicken with perfectly seasoned vegetables — a healthy delight.', '2025-11-14 19:45:00', '2025-11-14 19:45:00'),
(22, 32, 4.0, 'Good portion size and well-cooked. Great option for a balanced meal.', '2026-01-28 20:00:00', '2026-01-28 20:00:00'),
(29, 32, 3.5, 'Decent dish — the vegetables were excellent, though the chicken was slightly dry.', '2026-04-10 19:15:00', '2026-04-10 19:15:00'),

-- Dish 33 – Beef Steak
(11, 33, 5.0, 'Cooked exactly to my preference, tender and full of flavour. Outstanding!', '2025-12-01 20:30:00', '2025-12-01 20:30:00'),
(18, 33, 4.5, 'Best steak I have had in a while. The seasoning was absolutely spot on.', '2026-01-17 21:00:00', '2026-01-17 21:00:00'),
(26, 33, 4.0, 'Excellent quality beef, nicely charred outside and perfectly juicy inside.', '2026-02-25 20:15:00', '2026-02-25 20:15:00'),

-- Dish 34 – Salmon with Lemon Butter Sauce
(12, 34, 4.5, 'Perfectly flaky salmon — the lemon butter sauce elevated the whole dish.', '2025-11-18 19:00:00', '2025-11-18 19:00:00'),
(21, 34, 5.0, 'Melt-in-your-mouth salmon with a silky, citrusy sauce. Absolutely divine!', '2026-02-03 20:10:00', '2026-02-03 20:10:00'),
(30, 34, 4.0, 'Fresh fish, well prepared. The sauce was light and perfectly complementary.', '2026-03-28 19:40:00', '2026-03-28 19:40:00'),

-- Dish 35 – Chicken Curry with Rice
(15, 35, 4.5, 'Rich, aromatic curry with a great balance of spices. Incredibly comforting.', '2025-10-18 19:20:00', '2025-10-18 19:20:00'),
(24, 35, 4.0, 'Generous portion and full of flavour. The rice was perfectly fluffy.', '2026-01-09 20:00:00', '2026-01-09 20:00:00'),
(31, 35, 3.5, 'Good curry, though I would prefer it spicier. The chicken was very tender.', '2026-04-05 19:30:00', '2026-04-05 19:30:00'),

-- Dish 36 – Spaghetti Carbonara
(13, 36, 5.0, 'Creamy and indulgent — just as a proper carbonara should be. Absolute perfection!', '2025-12-08 20:45:00', '2025-12-08 20:45:00'),
(19, 36, 4.0, 'Authentic flavour with perfectly al dente pasta. A classic done well.', '2026-01-24 19:55:00', '2026-01-24 19:55:00'),
(28, 36, 4.5, 'Rich, silky sauce clinging to perfectly cooked pasta. Loved every single bite.', '2026-03-10 20:20:00', '2026-03-10 20:20:00'),

-- Dish 37 – Penne Alfredo
(16, 37, 4.0, 'Smooth, well-seasoned Alfredo sauce — very comforting and satisfying.', '2025-11-26 20:05:00', '2025-11-26 20:05:00'),
(23, 37, 4.5, 'Creamy and delicious. The Parmesan was generous and full of flavour.', '2026-02-19 19:50:00', '2026-02-19 19:50:00'),
(29, 37, 3.5, 'Decent pasta, nothing extraordinary but exactly what you want for comfort food.', '2026-04-15 20:10:00', '2026-04-15 20:10:00'),

-- Dish 38 – Margherita Pizza
(11, 38, 4.5, 'Simple yet brilliant — fresh mozzarella and a perfectly crispy thin crust.', '2026-01-03 19:00:00', '2026-01-03 19:00:00'),
(20, 38, 4.0, 'Classic done right. The tomato base was tangy and the crust wonderfully light.', '2026-02-10 19:30:00', '2026-02-10 19:30:00'),
(25, 38, 5.0, 'Best Margherita I have had! The quality of ingredients really shines through.', '2026-03-05 19:45:00', '2026-03-05 19:45:00'),
(31, 38, 4.0, 'Crispy base, great cheese pull. Nothing fancy but exactly what you crave.', '2026-04-18 20:00:00', '2026-04-18 20:00:00'),

-- Dish 39 – Pepperoni Pizza
(15, 39, 4.5, 'Loaded with pepperoni on a perfectly crispy crust. Absolutely loved it!', '2025-11-05 20:10:00', '2025-11-05 20:10:00'),
(22, 39, 4.0, 'Great pizza with generous toppings and a nicely charred base. Will order again.', '2026-02-28 20:30:00', '2026-02-28 20:30:00'),

-- Dish 40 – Cheeseburger
(12, 40, 4.5, 'Juicy patty with perfectly melted cheese — one of the best burgers around!', '2025-10-22 12:00:00', '2025-10-22 12:00:00'),
(18, 40, 4.0, 'Classic cheeseburger done well. Fresh ingredients and brilliant flavour.', '2025-12-30 13:15:00', '2025-12-30 13:15:00'),
(24, 40, 5.0, 'Perfect burger — juicy, cheesy, and absolutely delicious. My absolute favourite!', '2026-03-22 12:45:00', '2026-03-22 12:45:00'),

-- Dish 41 – Club Sandwich
(17, 41, 4.0, 'Stacked with fresh ingredients and bursting with flavour. Very generous portion.', '2025-11-10 12:30:00', '2025-11-10 12:30:00'),
(32, 41, 4.5, 'Perfectly layered with quality ingredients. Could not have been happier with it.', '2026-04-20 12:10:00', '2026-04-20 12:10:00'),

-- Dish 42 – Chocolate Cake
(13, 42, 5.0, 'Rich, moist, and absolutely decadent. The best chocolate dessert on the menu!', '2025-12-25 21:30:00', '2025-12-25 21:30:00'),
(21, 42, 4.5, 'Silky frosting and incredibly moist sponge. A perfect ending to any meal.', '2026-02-14 21:00:00', '2026-02-14 21:00:00'),
(27, 42, 4.0, 'Very indulgent chocolate cake. A touch sweet for my taste but beautifully made.', '2026-03-30 20:55:00', '2026-03-30 20:55:00');