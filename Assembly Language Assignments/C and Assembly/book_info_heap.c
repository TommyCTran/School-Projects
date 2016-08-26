#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <stdbool.h>
#include "book_info_heap.h"

/* Static Array */
#define large 20
static int head = 0;
static int previous = 0;	
static int count = 0;
static book_info arr[large];

/* If the book title is "NULL" then return true, otherwise return false */
bool isEmpty(book_info book)
{
	int flag = strcmp(book.title, " ");
	if(flag == 0) { return true; }
	else { return false; }
}

/* Creates and sends back an empty book */
book_info init_book() 
{
	count += 1;
	book_info book;
	strcpy(book.title, " ");
	strcpy(book.author, " ");
	if (count == 20) { count = -1; };
	book.year_published = count;
	return book;
}

/* Initializes the array of books */
/* Cannot use for loop. Otherwise would look cleaner. */
void init_heap() 
{ 
	arr[0] = init_book();
	arr[1] = init_book();
	arr[2] = init_book();
	arr[3] = init_book();
	arr[4] = init_book();
	arr[5] = init_book();
	arr[6] = init_book();
	arr[7] = init_book();
	arr[8] = init_book();
	arr[9] = init_book();
	arr[10] = init_book();
	arr[11] = init_book();
	arr[12] = init_book();
	arr[13] = init_book();
	arr[14] = init_book();
	arr[15] = init_book();
	arr[16] = init_book();
	arr[17] = init_book();
	arr[18] = init_book();
	arr[19] = init_book();
	
}

/* If the array of book has an empty slot, then return the pointer to that slot. Otherwise, return NULL */
book_info * new_book_info()
{
	if(arr[previous].year_published != -1) { previous = head; }
	if(isEmpty(arr[head])) {
		head = arr[previous].year_published; 
		return &arr[previous]; 
	}
	else { return NULL; }	
}

/* Takes the book pointer and resets all of the values of the book */
void del_book_info(book_info *book)
{	
	book_info *p1 = &arr[0];
	book_info *p2 = book;
	int val = p2 - p1;

	/* Checks to see if pointer is within the array */
	if (val >= 0 && val < 20)
	{
		/* Resets the title */
		strcpy(book->title, " ");
		/* Resets the author */
		strcpy(book->author, " ");
		/* Checks to see the next avaliable slot */
		book->year_published = head;
		head = val;
	}
	else
	{
		printf("ERROR: Incorrect Pointer");	
		exit(0);
	}
}

/* Prints out the array */
void dump_heap()
{
	printf("*** BEGIN HEAP DUMP ***\n");
	printf("head = %d\n", head);
	printf("0: %d, %s, %s\n", arr[0].year_published, arr[0].title, arr[0].author);
	printf("1: %d, %s, %s\n", arr[1].year_published, arr[1].title, arr[1].author);
	printf("2: %d, %s, %s\n", arr[2].year_published, arr[2].title, arr[2].author);
	printf("3: %d, %s, %s\n", arr[3].year_published, arr[3].title, arr[3].author);
	printf("4: %d, %s, %s\n", arr[4].year_published, arr[4].title, arr[4].author);
	printf("5: %d, %s, %s\n", arr[5].year_published, arr[5].title, arr[5].author);
	printf("6: %d, %s, %s\n", arr[6].year_published, arr[6].title, arr[6].author);
	printf("7: %d, %s, %s\n", arr[7].year_published, arr[7].title, arr[7].author);
	printf("8: %d, %s, %s\n", arr[8].year_published, arr[8].title, arr[8].author);
	printf("9: %d, %s, %s\n", arr[9].year_published, arr[9].title, arr[9].author);
	printf("10: %d, %s, %s\n", arr[10].year_published, arr[10].title, arr[10].author);
	printf("11: %d, %s, %s\n", arr[11].year_published, arr[11].title, arr[11].author);
	printf("12: %d, %s, %s\n", arr[12].year_published, arr[12].title, arr[12].author);
	printf("13: %d, %s, %s\n", arr[13].year_published, arr[13].title, arr[13].author);
	printf("14: %d, %s, %s\n", arr[14].year_published, arr[14].title, arr[14].author);
	printf("15: %d, %s, %s\n", arr[15].year_published, arr[15].title, arr[15].author);
	printf("16: %d, %s, %s\n", arr[16].year_published, arr[16].title, arr[16].author);
	printf("17: %d, %s, %s\n", arr[17].year_published, arr[17].title, arr[17].author);
	printf("18: %d, %s, %s\n", arr[18].year_published, arr[18].title, arr[18].author);
	printf("19: %d, %s, %s\n", arr[19].year_published, arr[19].title, arr[19].author);
	printf("*** END HEAP DUMP ***\n");
}