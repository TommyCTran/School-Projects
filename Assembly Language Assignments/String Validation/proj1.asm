%define STDIN 0
%define STDOUT 1
%define SYSCALL_EXIT  1
%define SYSCALL_READ  3
%define SYSCALL_WRITE 4
%define BUFLEN 256


        SECTION .data                   ; initialized data section

msg1:   db "Enter 12-digit UPC: "             	; user prompt
len1:   equ $-msg1                      	; length of first message

msg2:   db "This is a valid UPC number. "      ; original string label
len2:   equ $-msg2                      	; length of second message

msg3:   db "This is NOT a valid UPC number. "	; converted string label
len3:   equ $-msg3


arr:	dd 0, 3, 6, 9, 2, 5, 8, 1, 4, 7 ;


	SECTION .bss                    ; uninitialized data section

rbuf:   resb BUFLEN			; buffer for read
dbuf:	resb BUFLEN			; destination buffer
rlen:   resb 4                          ; length

        SECTION .text                   ; Code section.
        global  _start                  ; let loader see entry point

_start: nop                             ; Entry point.
start:                                  ; address for gdb

        ; prompt user for input
        ;
        mov     eax, SYSCALL_WRITE      ; write function
        mov     ebx, STDOUT             ; Arg1: file descriptor
        mov     ecx, msg1               ; Arg2: addr of message
        mov     edx, len1               ; lsArg3: length of message
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
	xor	eax, eax	; Check Digit
	xor	ebx, ebx	; Index
	xor	ecx, ecx	; And Value
	xor	edx, edx	; Buffer Value
	xor	esi, esi	; Look up Value
	xor	edi, edi	; New Value
		
loop:
	nop
	cmp	ebx, 11
	jge	end
	mov	ecx, ebx
	and 	ecx, 1
	cmp	ecx, 1
	jne	even
	jmp	odd

even:
	nop
	mov	edx, [rbuf + ebx]
	and	edx, 0x0F		; Convert to Binary
	mov	edi, [edx * 4 + arr]
	add	eax, edi
	jmp	check

odd:
	nop
	mov	edx, [rbuf + ebx]
	and	edx, 0x0F		; Convert to Binary
	add	eax, edx
	jmp	check
	
check:
	nop
	inc	ebx
	cmp	eax, 10
	jl	loop
	sub	eax, 10
	jmp	loop

end:
	nop
	cmp 	eax, 0
	jle	done
	mov	edi, 10
	sub	edi, eax
	mov	eax, edi
	
done:
	nop
	mov	edx, [rbuf + 11]
	and	edx, 0x0F
	cmp	eax, edx
	jne	error

        ; print out user input for feedback
        ;

 	; print out converted string
        ;
        mov     eax, SYSCALL_WRITE      ; write message
        mov     ebx, STDOUT
        mov     ecx, msg2
        mov     edx, len2
        int     080h
	jmp 	exit
        
	; final exit
        ;
error:
	nop
        mov     eax, SYSCALL_WRITE      ; write out string
        mov     ebx, STDOUT
        mov     ecx, msg3
        mov     edx, len3
        int     080h

exit:   
	nop	
	mov     eax, SYSCALL_EXIT       ; exit function
        mov     ebx, 0                  ; exit code, 0=normal
        int     080h                    ; ask kernel to take over 
