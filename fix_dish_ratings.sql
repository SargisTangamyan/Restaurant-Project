-- ============================================================
-- STEP 1: Backfill average_rating + reviews_count from
--         existing dish_reviews rows
-- ============================================================
UPDATE dishes d
INNER JOIN (
    SELECT
        dish_id,
        COUNT(*)               AS cnt,
        ROUND(AVG(rating), 1)  AS avg_rating
    FROM dish_reviews
    GROUP BY dish_id
) agg ON d.id = agg.dish_id
SET
    d.reviews_count  = agg.cnt,
    d.average_rating = agg.avg_rating;

-- ============================================================
-- STEP 2: Triggers — keep the columns in sync forever
-- ============================================================

DROP TRIGGER IF EXISTS trg_dish_reviews_after_insert;
DROP TRIGGER IF EXISTS trg_dish_reviews_after_update;
DROP TRIGGER IF EXISTS trg_dish_reviews_after_delete;

CREATE TRIGGER trg_dish_reviews_after_insert
AFTER INSERT ON dish_reviews
FOR EACH ROW
    UPDATE dishes
    SET
        reviews_count  = (SELECT COUNT(*)              FROM dish_reviews WHERE dish_id = NEW.dish_id),
        average_rating = (SELECT ROUND(AVG(rating), 1) FROM dish_reviews WHERE dish_id = NEW.dish_id)
    WHERE id = NEW.dish_id;

CREATE TRIGGER trg_dish_reviews_after_update
AFTER UPDATE ON dish_reviews
FOR EACH ROW
    UPDATE dishes
    SET
        average_rating = (SELECT ROUND(AVG(rating), 1) FROM dish_reviews WHERE dish_id = NEW.dish_id)
    WHERE id = NEW.dish_id;

CREATE TRIGGER trg_dish_reviews_after_delete
AFTER DELETE ON dish_reviews
FOR EACH ROW
    UPDATE dishes
    SET
        reviews_count  = (SELECT COUNT(*)                       FROM dish_reviews WHERE dish_id = OLD.dish_id),
        average_rating = COALESCE(
                            (SELECT ROUND(AVG(rating), 1) FROM dish_reviews WHERE dish_id = OLD.dish_id),
                            0.0
                         )
    WHERE id = OLD.dish_id;