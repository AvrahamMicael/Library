create database library charset set utf8 collate utf8_unicode_ci;

create table tb_books(
    id int not null primary key AUTO_INCREMENT,
	author varchar(100) not null,
    title varchar(100) not null,
    description text not null,
    published_at int not null,
    pages int not null,
    available int not null default 1,
    genres varchar(100) not null,
    image_link varchar(256) not null
);
create table tb_users(
	id_user int not null primary key AUTO_INCREMENT,
    name varchar(50) not null,
    email varchar(50) not null,
    password char(128) not null,
    id_book1 int,
    foreign key(id_book1) references tb_books(id),
    id_book2 int,
    foreign key(id_book2) references tb_books(id)
);
create table tb_requests(
	request_sender_id int not null,
    foreign key(request_sender_id) references tb_users(id_user),
    requested_book_id int not null,
    foreign key(requested_book_id) references tb_books(id)
);
create table tb_notifications(
    id_not int not null primary key AUTO_INCREMENT,
    notification varchar(50) not null,
    id_user int not null,
    foreign key(id_user) references tb_users(id_user)
);

--the user with id 1 is the admin

insert into tb_books(
    title, 
    author, 
    description, 
    published_at, 
    pages, 
    genres,
    image_link
)
values(
    "The Hunger Games: Volume 1",
    "Suzanne Collins",
    "The first novel in the worldwide bestselling series by Suzanne Collins!Winning means fame and fortune. Losing means certain death. The Hunger Games have begun....",
    2010,
    374,
    "Thriller#SF#Adventure#Young Adult Fiction",
    "https://images-na.ssl-images-amazon.com/images/I/41WAJbx1e2L._SY344_BO1,204,203,200_QL70_ML2_.jpg"
),
(
    "Brave New World",
    "Aldous Huxley",
    "Far in the future, the World Controllers have created the ideal society.Huxley's ingenious fantasy of the future sheds a blazing light on the present and is considered to be his most enduring masterpiece.",
    1932,
    311,
    "SF#Dystopian Fiction",
    "https://images-na.ssl-images-amazon.com/images/I/41-n-3hZMeL._SX325_BO1,204,203,200_.jpg"
),
(
    "1984",
    "George Orwell",
    "1984 is a dystopian novella by George Orwell published in 1949, which follows the life of Winston Smith, a low ranking member of 'the Party', who is frustrated by the omnipresent eyes of the party, and its ominous ruler Big Brother. 'Big Brother' controls every aspect of people's lives.",
    1949,
    328,
    "Dystopian#Political Fiction#Social SF",
    "https://m.media-amazon.com/images/I/819js3EQwbL._AC_UY218_.jpg"
),
(
    "Human Action",
    "Ludwig Von Mises",
    "Human Action: A Treatise on Economics is a work by the Austrian economist and philosopher Ludwig von Mises. Widely considered Mises' magnum opus, it presents the case for laissez-faire capitalism based on praxeology, his method to understand the structure of human decision-making. ",
    1949,
    881,
    "Non-fiction#Tretise#Economics",
    "https://m.media-amazon.com/images/I/71TG64OAWvL._AC_UY218_.jpg"
),
(
    "Where the Crawdads Sing",
    "Delia Owens",
    "SOON TO BE A MAJOR MOTION PICTURE—The #1 New York Times bestselling worldwide sensation with more than 12 million copies sold, “a painfully beautiful first novel that is at once a murder mystery, a coming-of-age narrative and a celebration of nature”(The New York Times Book Review), now in paperback for the first time. For years, rumors of the 'Marsh Girl' have haunted Barkley Cove, a quiet town on the North Carolina coast. So in late 1969, when handsome Chase Andrews is found dead, the locals immediately suspect Kya Clark, the so-called Marsh Girl. But Kya is not what they say. Sensitive and intelligent, she has survived for years alone in the marsh that she calls home, finding friends in the gulls and lessons in the sand. Then the time comes when she yearns to be touched and loved. When two young men from town become intrigued by her wild beauty, Kya opens herself to a new life--until the unthinkable happens. Where the Crawdads Sing is at once an exquisite ode to the natural world, a heartbreaking coming-of-age story, and a surprising tale of possible murder. Owens reminds us that we are forever shaped by the children we once were, and that we are all subject to the beautiful and violent secrets that nature keeps.",
    2021,
    400,
    "Literary Fiction#Mothers & Children Fiction",
    "https://images-na.ssl-images-amazon.com/images/I/41rzRPDRxJL._SX331_BO1,204,203,200_.jpg"
),
(
    "The Anatomy of Anxiety: Understanding and Overcoming the Body's Fear Response",
    "Ellen Vora",
    "Anxiety affects more than forty million Americans—a number that continues to climb in the wake of the COVID-19 pandemic. While conventional medicine tends to view anxiety as a “neck-up” problem—that is, one of brain chemistry and psychology—the truth is that the origins of anxiety are rooted in the body.",
    2022,
    352,
    "Depression",
    "https://images-na.ssl-images-amazon.com/images/I/41UmFoClNSL._SX333_BO1,204,203,200_.jpg"
),
(
    "Riverman: An American Odyssey",
    "Ben McGrath",
    "For decades, Dick Conant paddled the rivers of America, covering the Mississippi, Yellowstone, Ohio, Hudson, as well as innumerable smaller tributaries. These solo excursions were epic feats of planning, perseverance, and physical courage. At the same time, Conant collected people wherever he went, creating a vast network of friends and acquaintances who would forever remember this brilliant and charming man even after a single meeting.",
    2022,
    272,
    "Travel#Earth Science",
    "https://images-na.ssl-images-amazon.com/images/I/41zhPgZ8GzL._SX336_BO1,204,203,200_.jpg"
);