#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <stdbool.h>

#ifndef BOOK_INFO_HEAP_H_
#define BOOK_INFO_HEAP_H_

typedef struct book_info
{
	char title[50];
	char author[50];
	unsigned int year_published;
} book_info;

book_info init_book();
void init_heap();
bool isEmpty();
book_info * new_book_info();
void del_book_info();
void dump_heap();

#endif