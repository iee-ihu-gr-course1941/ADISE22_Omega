# ADISE22_Omega
## Table of contents
======================
   * [Εγκατάσταση](#εγκατάσταση)
      * [Απαιτήσεις](#απαιτήσεις)
      * [Οδηγίες Εγκατάστασης](#οδηγίες-εγκατάστασης)
   * [Περιγραφή Παιχνιδιού](#περιγραφή-παιχνιδιού)
   * [Περιγραφή API](#περιγραφή-api)
      * [Methods](#methods)
         * [Board](#board)
            * [Ανάγνωση Board](#ανάγνωση-board)
            * [Αρχικοποίηση Board](#αρχικοποίηση-board)
         * [Cards](#cards)
            * [Ανάγνωση κάρτας και των συνδιασμών του](#ανάγνωση-κάρτας)
            * [Παίξιμο κάρτας](#παίξιμο-κάρτας)
         * [Player](#player)
            * [Ανάγνωση στοιχείων παίκτη](#ανάγνωση-στοιχείων-παίκτη)
            * [Καθορισμός στοιχείων παίκτη](#καθορισμός-στοιχείων-παίκτη)
         * [Status](#status)
            * [Ανάγνωση κατάστασης παιχνιδιού](#ανάγνωση-κατάστασης-παιχνιδιού)
      * [Entities](#entities)
         * [Deck](#deck)
         * [Clonedeck](#clonedeck)
         * [Players](#players)
         * [Hand](#hand)
         * [Discarded_cards](#discarded_cards)
         * [Game_status](#game_status)

## Οδηγίες Εγκατάστασης

 * Κάντε clone το project σε κάποιον φάκελο <br/>
  `$ git clone https://github.com/iee-ihu-gr-course1941/Lectures21-chess.git`

 * Βεβαιωθείτε ότι ο φάκελος είναι προσβάσιμος από τον Apache Server. πιθανόν να χρειαστεί να καθορίσετε τις παρακάτω ρυθμίσεις.

 * Θα πρέπει να δημιουργήσετε στην Mysql την βάση με όνομα 'adise21' και να φορτώσετε σε αυτήν την βάση τα δεδομένα από το αρχείο schema.sql

 * Θα πρέπει να φτιάξετε το αρχείο lib/config_local.php το οποίο να περιέχει:
 
## Περιγραφή Παιχνιδιού
Σκοπός του παιχνιδιού είναι να δημιουργείτε τριάδες ή μεγαλύτερες σειρές φύλλων (τετράδες, πεντάδες κτλ). Μια σειρά μπορεί να αποτελείται είτε από τρία ή τέσσερα φύλλα ίδιου αριθμού (π.χ. 3 τεσσάρια ή 4 Βαλέδες κτλ) είτε από σειρά φύλλων ίδιου χρώματος σε αριθμητική συνέχεια (π.χ. Καρό από το 5 μέχρι το 8). Στην περίπτωση σειράς φύλλων η αριθμητική συνέχεια των φύλλων είναι 1 έως 10, J, Q, K, A. Ο μπαλαντέρ του παιχνιδιού που μπορείτε να τον χρησιμοποιήσετε στην θέση οποιοδήποτε φύλλου είναι το 2.   Κάθε φορά που έχετε μια τριάδα (ή περισσότερα) φύλλων μπορείτε να τα κατεβάσετε απο το χέρι σας κάτω. (Τα τοποθετείτε ανοιχτά μπροστά σας.)   Νικητής της παρτίδας είναι αυτός που θα "βγεί" δηλαδή θα κατεβάσει όλα τα φύλλα του και θα μείνει χωρίς φύλλο στο χέρι.
 
 
 
 
 
 
# Περιγραφή API




## Methods



## Entities


### Deck
---------

Ο deck είναι ένας πίνακας, ο οποίος αντιπροσωπεύει τα στοιχεία όλων των καρτών. Δεν τροποποιείται ωστόσο χρησιμοποιείται για sql ερωτήματα για σύνδεση πινάκων (πχ join). Το κάθε στοιχείο έχει τα παρακάτω:


| Attribute                | Description                                 | Values                               |
| ------------------------ | --------------------------------------------| -------------------------------------|
| `card_number`            | H αριθμητική τιμη μιας κάρτας               | 1..13                                |
| `cardCode`               | Η αλφαριθμητικη τιμής μιας κάρτας           | 1H..13H, 1S..13S,1S..13S,1C..13C     |
| `cardId`                 | Μια μοναδική αριθμητική τιμή για κάθε κάρτα | 1..52                                |




### Clonedeck
---------

Ο clonedeck είναι ένας πίνακας, ο οποίος έχει ό,τι και ο deck. Αντιπροσωπεύει τις κάρτες που βρίσκονται στην κλειστή στοίβα και σε αντίθεση με τον deck, τροποποιείαι (Σε περίπτωση κίνησης υπάρχει η δυνατότητα insert/delete εντολών πάνω σε αυτόν τον πίνακα). Έχει τα παρακάτω στοιχεία:


| Attribute                | Description                                 | Values                               |
| ------------------------ | --------------------------------------------| ------------------------------------ |
| `card_number`            | H αριθμητική τιμη μιας κάρτας               | 1..13                                |
| `cardCode`               | Η αλφαριθμητικη τιμής μιας κάρτας           | 1H..13H, 1S..13S,1S..13S,1C..13C     |
| `cardId`                 | Μια μοναδική αριθμητική τιμή για κάθε κάρτα | 1..52                                |


### Players
---------

O κάθε παίκτης έχει τα παρακάτω στοιχεία:


| Attribute                | Description                                    | Values                             |
| ------------------------ | -----------------------------------------------| -----------------------------------|
| `username`               | Όνομα παίκτη                                   | String                             |
| `playerId`               | Ένα μοναδικό Id για κάθε παίκτη                | Integer                            |
| `token  `                | To κρυφό token του παίκτη. Επιστρέφεται μόνο τη στιγμή της εισόδου του παίκτη στο παιχνίδι | HEX |
| `last_action`            | Η τελευταία χρονική στιγμή που έκανε κάποιος παίκτης μια κίνηση| timestamp          |
| `p_turn`                 | Αριθμός που αποτελεί κριτήριο για το ποιος παίκτης παίζει   | 0,1                   |



### Hand
---------

O hand είναι ένας πίνακας, ο οποίος αντιπροσωπεύει τις κάρτες που έχει ο κάθε παίκτης στα χέρια του. Κάθε στοιχείο έχει τα παρακάτω:


| Attribute                | Description                                 | Values                                |
| ------------------------ | --------------------------------------------| -----------------------------------   |
| `playerId`            | Ένα μοναδικό Id για κάθε παίκτη                | Integer                               |
| `cardId`                 | Μια μοναδική αριθμητική τιμή για κάθε κάρτα | 1..52                                 |


### Discarded_cards
---------

O discarded_cards είναι ένας πίνακας, ο οποίος αντιπροσωπεύει τις κάρτες που βρίσκονται στην ανοικτή στοίβα. Κάθε στοιχείο έχει τα παρακάτω:


| Attribute                | Description                                 | Values                                |
| ------------------------ | --------------------------------------------| -----------------------------------   |
| `playerId`               | Ένα μοναδικό Id για κάθε παίκτη             | Integer                               |
| `cardCode`               | Η αλφαριθμητικη τιμής μιας κάρτας           | 1H..13H, 1S..13S,1S..13S,1C..13C      |


### Game_status
---------

H κατάσταση παιχνιδιού έχει τα παρακάτω στοιχεία:


| Attribute                | Description                                 | Values                                                         |
| ------------------------ | --------------------------------------------| ---------------------------------------------------------------|
| `g_status  `             | Κατάσταση                                   | 'not active', 'initialized', 'started', 'ended', 'aborded'     |
| `p_turn`                 | Αριθμός που αποτελεί κριτήριο για το ποιος παίκτης παίζει   | 0,1                                            |
| `result`                 |  Το αναγνωριστικό του παίκτη που κέρδισε ή παραδόθηκε  |'user1','user2'                                      |
| `last_change`            | Τελευταία αλλαγή/ενέργεια στην κατάσταση του παιχνιδιού         | timestamp                                  |
