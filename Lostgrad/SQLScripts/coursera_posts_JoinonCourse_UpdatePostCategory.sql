    
#COMPUTER SCIENCE
UPDATE hotaru_posts as P

    INNER JOIN lostgrad_course as C
    ON P.post_id = C.post_id
        
SET P.post_category= 3
    WHERE C.initiative_category_id = 1;

#ECONOMICS AND FINANCE
UPDATE hotaru_posts as P

    INNER JOIN lostgrad_course as C
    ON P.post_id = C.post_id
        
SET P.post_category= 5
    WHERE C.initiative_category_id = 2;

#MEDICINE
UPDATE hotaru_posts as P

    INNER JOIN lostgrad_course as C
    ON P.post_id = C.post_id
        
SET P.post_category= 10
    WHERE C.initiative_category_id = 3;

#INFORMATION TECHNOLOGY & DESIGN

UPDATE hotaru_posts as P

    INNER JOIN lostgrad_course as C
    ON P.post_id = C.post_id
        
SET P.post_category= 3 #todo
    WHERE C.initiative_category_id = 4;

#MATHS
UPDATE hotaru_posts as P

    INNER JOIN lostgrad_course as C
    ON P.post_id = C.post_id
        
SET P.post_category= 13
    WHERE C.initiative_category_id = 5;

#HUMANITIES

UPDATE hotaru_posts as P

    INNER JOIN lostgrad_course as C
    ON P.post_id = C.post_id
        
SET P.post_category= 14
    WHERE C.initiative_category_id = 6;

#HEALTH & SOCIETY

UPDATE hotaru_posts as P

    INNER JOIN lostgrad_course as C
    ON P.post_id = C.post_id
        
SET P.post_category= 12
    WHERE C.initiative_category_id = 8;

#EARTH SCIENCES
UPDATE hotaru_posts as P

    INNER JOIN lostgrad_course as C
    ON P.post_id = C.post_id
        
SET P.post_category= 9 #todo
    WHERE C.initiative_category_id = 9;


#BIOLOGY
UPDATE hotaru_posts as P

    INNER JOIN lostgrad_course as C
    ON P.post_id = C.post_id
        
SET P.post_category= 9 #todo
    WHERE C.initiative_category_id = 10;

#SYSTEMS & SECURITY
UPDATE hotaru_posts as P

    INNER JOIN lostgrad_course as C
    ON P.post_id = C.post_id
        
SET P.post_category= 3 
    WHERE C.initiative_category_id = 11;

#SOFTWARE ENG
UPDATE hotaru_posts as P

    INNER JOIN lostgrad_course as C
    ON P.post_id = C.post_id
        
SET P.post_category= 3
    WHERE C.initiative_category_id = 12;

#BAM
UPDATE hotaru_posts as P

    INNER JOIN lostgrad_course as C
    ON P.post_id = C.post_id
        
SET P.post_category= 4
    WHERE C.initiative_category_id = 13;

#TEACHING & EDUCATION

UPDATE hotaru_posts as P

    INNER JOIN lostgrad_course as C
    ON P.post_id = C.post_id
        
SET P.post_category= 1#todo
    WHERE C.initiative_category_id = 14;

#ENGINEERING
UPDATE hotaru_posts as P

    INNER JOIN lostgrad_course as C
    ON P.post_id = C.post_id
        
SET P.post_category= 6
    WHERE C.initiative_category_id = 15;

#STATSDATA
UPDATE hotaru_posts as P

    INNER JOIN lostgrad_course as C
    ON P.post_id = C.post_id
        
SET P.post_category= 13#todo
    WHERE C.initiative_category_id = 16;

#AI
UPDATE hotaru_posts as P

    INNER JOIN lostgrad_course as C
    ON P.post_id = C.post_id
        
SET P.post_category= 2 #todo
    WHERE C.initiative_category_id = 17;

#MUSIC FILM AUDIO
UPDATE hotaru_posts as P

    INNER JOIN lostgrad_course as C
    ON P.post_id = C.post_id
        
SET P.post_category= 8 #todo
    WHERE C.initiative_category_id = 18;

#SOCIAL SCIENCE
UPDATE hotaru_posts as P

    INNER JOIN lostgrad_course as C
    ON P.post_id = C.post_id
        
SET P.post_category= 13#todo
    WHERE C.initiative_category_id = 20;

#ARTS
UPDATE hotaru_posts as P

    INNER JOIN lostgrad_course as C
    ON P.post_id = C.post_id
        
SET P.post_category= 8
    WHERE C.initiative_category_id = 22;

#Physics
UPDATE hotaru_posts as P

    INNER JOIN lostgrad_course as C
    ON P.post_id = C.post_id
        
SET P.post_category= 9#todo
    WHERE C.initiative_category_id = 23;

#Chem
UPDATE hotaru_posts as P

    INNER JOIN lostgrad_course as C
    ON P.post_id = C.post_id
        
SET P.post_category= 9#todo
    WHERE C.initiative_category_id = 24;

#Energy earth science
UPDATE hotaru_posts as P

    INNER JOIN lostgrad_course as C
    ON P.post_id = C.post_id
        
SET P.post_category= 9#todo
    WHERE C.initiative_category_id = 25;