
/*==============================================================*/
/* Table: List_of_posts                                         */
/*==============================================================*/
create table List_of_posts (
   User_ID              INT4                 not null,
   Post_ID              INT4                 not null,
   List_ID              SERIAL               not null,
   Path                 VARCHAR(500)         not null,
   constraint PK_LIST_OF_POSTS primary key (User_ID, Post_ID, List_ID)
);

/*==============================================================*/
/* Index: List_of_posts_PK                                      */
/*==============================================================*/
create unique index List_of_posts_PK on List_of_posts (
User_ID,
Post_ID,
List_ID
);

/*==============================================================*/
/* Index: PL_FK                                                 */
/*==============================================================*/
create  index PL_FK on List_of_posts (
User_ID,
Post_ID
);

/*==============================================================*/
/* Table: Posts                                                 */
/*==============================================================*/
create table Posts (
   User_ID              INT4                 not null,
   Post_ID              SERIAL               not null,
   Title                VARCHAR(200)         not null,
   Description          TEXT                 not null,
   Date                 DATE                 not null,
   constraint PK_POSTS primary key (User_ID, Post_ID)
);

/*==============================================================*/
/* Index: Posts_PK                                              */
/*==============================================================*/
create unique index Posts_PK on Posts (
User_ID,
Post_ID
);

/*==============================================================*/
/* Index: UP_FK                                                 */
/*==============================================================*/
create  index UP_FK on Posts (
User_ID
);

/*==============================================================*/
/* Table: Users                                                 */
/*==============================================================*/
create table Users (
   Name                 VARCHAR(200)         not null,
   Login                VARCHAR(200)         not null,
   Email                VARCHAR(200)         not null,
   Password             VARCHAR(200)         not null,
   Avatar               VARCHAR(500)         not null,
   User_ID              SERIAL               not null,
   constraint PK_USERS primary key (User_ID)
);

/*==============================================================*/
/* Index: Users_PK                                              */
/*==============================================================*/
create unique index Users_PK on Users (
User_ID
);

alter table List_of_posts
   add constraint FK_LIST_OF__PL_POSTS foreign key (User_ID, Post_ID)
      references Posts (User_ID, Post_ID)
      on delete restrict on update restrict;

alter table Posts
   add constraint FK_POSTS_UP_USERS foreign key (User_ID)
      references Users (User_ID)
      on delete restrict on update restrict;

