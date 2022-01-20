SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `videos` 
ADD COLUMN `likes` INT(11) NULL DEFAULT NULL,
ADD COLUMN `dislikes` INT(11) NULL DEFAULT NULL,
ADD INDEX `videos_likes_index` (`likes` ASC),
ADD INDEX `videos_dislikes_index` (`dislikes` ASC);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

UPDATE configurations SET  version = '11.5', modified = now() WHERE id = 1;