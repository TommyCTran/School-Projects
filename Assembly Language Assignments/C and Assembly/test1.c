/*
 * main5.c
 *
 *  Created on: Mar 25, 2015
 *      Author: acw3f
 */

#include <stdio.h>
#include <string.h>
#include "book_info_heap.h"

book_info *get_new_book_info(char *title, char *author, unsigned int year_published)
{
    book_info *info = new_book_info();
    if (info == NULL)
    {
        return NULL;
    }
    strncpy(info->title, title, sizeof(info->title) - 1);
    strncpy(info->author, author, sizeof(info->author) - 1);
    info->year_published = year_published;
    return info;
}

void print_info(const book_info *info)
{
    printf("Book Title: %s\n", info->title);
    printf("Book Author: %s\n", info->author);
    printf("Book Year Published: %u\n", info->year_published);
}

int main()
{
    book_info *info1, *info2, *info3, *info4, *info5, *info6, *info7, *info8, *info9, *info10;

    init_heap();

    info1 = get_new_book_info("Book 1", "Author 1", 2001);

    dump_heap();

    del_book_info(info1);

    dump_heap();

    info1 = get_new_book_info("Book 1", "Author 1", 2001);
	
    info2 = get_new_book_info("Book 2", "Author 2", 2002);

    info3 = get_new_book_info("Book 3", "Author 3", 2003);

    info4 = get_new_book_info("Book 4", "Author 4", 2004);

    info5 = get_new_book_info("Book 5", "Author 5", 2005);

    info6 = get_new_book_info("Book 6", "Author 6", 2006);

    info7 = get_new_book_info("Book 7", "Author 7", 2007);

    info8 = get_new_book_info("Book 8", "Author 8", 2008);

    info9 = get_new_book_info("Book 9", "Author 9", 2009);

    info10 = get_new_book_info("Book 10", "Author 10", 2010);

    info1 = get_new_book_info("Book 1", "Author 1", 2001);
	
    info2 = get_new_book_info("Book 2", "Author 2", 2002);

    info3 = get_new_book_info("Book 3", "Author 3", 2003);

    info4 = get_new_book_info("Book 4", "Author 4", 2004);

    info5 = get_new_book_info("Book 5", "Author 5", 2005);

    info6 = get_new_book_info("Book 6", "Author 6", 2006);

    info7 = get_new_book_info("Book 7", "Author 7", 2007);

    info8 = get_new_book_info("Book 8", "Author 8", 2008);

    info9 = get_new_book_info("Book 9", "Author 9", 2009);

    info10 = get_new_book_info("Book 10", "Author 10", 2010);

    dump_heap();

    del_book_info(info5);

    dump_heap();

    del_book_info(info8);

    dump_heap();
    
    del_book_info(info3);

    dump_heap();

    dump_heap();

    return 0;
}