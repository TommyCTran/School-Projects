%define STDIN 0
%define STDOUT 1
%define SYSCALL_EXIT  1
%define SYSCALL_READ  3
%define SYSCALL_WRITE 4
%define BUFLEN 256


        SECTION .data                   ; initialized data section

msg1:   db "Expression to Calculate: "          ; user prompt
len1:   equ $-msg1                      	; length of first message

msg2:   db "Returned number: %d", 10, 0		; the returned value message
len2:   equ $-msg2                      	; length of second message


	SECTION .bss                    ; uninitialized data section

rbuf:   resb BUFLEN			; buffer for read
dbuf:	resb BUFLEN			; destination buffer
rlen:   resb 4                          ; length

        SECTION .text                   ; Code section.
	extern printf			; Request access to printf
	extern atoi			; Request access to atoi
        global  main	                ; let loader see entry point

main: nop  	                        ; Entry point.
start:                                  ; address for gdb

        ; prompt user for input
        ;
        mov     eax, SYSCALL_WRITE      ; write function
        mov     ebx, STDOUT             ; Arg1: file descriptor
        mov     ecx, msg1               ; Arg2: addr of message
        mov     edx, len1               ; Arg3: length of message
        int     080h                    ; ask kernel to write

        ; read user input
        ;
        mov     eax, SYSCALL_READ       ; read function
        mov     ebx, STDIN              ; Arg 1: file descriptor
        mov     ecx, rbuf               ; Arg 2: address of buffer
        mov     edx, BUFLEN             ; Arg 3: buffer length
        int     080h

        ; error check
        ;
        cmp     eax, 0                  ; check if any chars read
        jg      read_OK                 ; >0 chars read = OK


read_OK:
	; begin checking the input
	nop	
	mov	[rlen], eax		; Saves the length of the buffer
	mov	ebx, rbuf		; Sets the Address of Rbuf
	xor	eax, eax		; Division value
	xor	ecx, ecx		; Division value
	xor	edx, edx		; Division value
	xor	esi, esi		; Rbuf count
	xor	edi, edi		; Pop value
	

loop:	
	cmp	esi, [rlen]
	jge	done
	
	mov	al, [rbuf + esi]	; Moves rbuf Individual values to ecx	

	
	cmp 	al, 43		; Comparison for "+" Operator
					; 43 is decimal value of "+"
	je	addition	; Jumps to addition label
	cmp	al, 45		; Comparison for "-" Operator
					; 45 is decimal value of "-"
	je 	subtraction	; Jumps to subtraction label
	cmp 	al, 42		; Comparison for "*" Operator
					; 42 is decimal value of "*"
	je	multiplication	; Jumps to multiplication label
	cmp	al, 47		; Comparison for "/" Operator
					; 47 is decimal value of "/"
	je 	division	; Jumps to division label
	cmp	al, 32		; Comparison for whitespace
					; 32 is decimal value of " "
	je 	whitespace	; Jumps to whitespace label
	cmp 	al, 10		; Comparison for "\n" Operator
					; 10 is decimal value of "\n"
	je	newline		; Jumps to newLine label
	
	jmp	value		; Jump to increment the values
stack:

	push 	ebx
	call	atoi
	add	esp, 4	
	push	eax

	inc	esi
	add 	ebx, esi
	

	jmp	loop		; Just out of while loop if its greater than or equal

addition:

	pop	edi
	pop	eax	
	add	edi, eax
	push	edi
	inc	esi
	jmp	loop	

subtraction:
	
	call	neg

	mov 	dl, [rbuf + esi + 1]
	cmp	dl , 32
	jne	value

	pop	edi
	pop	eax	
	sub	eax, edi
	push	eax
	inc	esi
	jmp 	loop

multiplication:

	pop	edi
	pop	eax	
	imul	edi, eax
	push	edi
	inc 	esi
	jmp 	loop

division:

	mov	edx, 0
	pop	ecx
	pop	eax
	idiv	ecx
	push	eax
	inc	esi
	jmp	loop		

whitespace:
	
	inc	esi
	jmp 	loop

newline:
	
	jmp 	done

value:

	mov 	dl, [rbuf + esi + 1]
	cmp	dl , 32
	je	stack
	inc 	esi
	jmp 	value

neg:

	ret	; Useless
		; Didn't need to use call/ret


done:
	
	push	msg2	
	call 	printf

	nop		

	; final exit
        ;
exit:   
	nop	
	mov     eax, SYSCALL_EXIT       ; exit function
        mov     ebx, 0                  ; exit code, 0=normal
        int     080h                    ; ask kernel to take over 
