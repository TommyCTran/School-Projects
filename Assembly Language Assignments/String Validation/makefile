AS=nasm
LD=ld
ASFLAGS=-f elf -g -F stabs
LDFLAGS=-melf_i386
.PREFIXES= .o .asm

ALL_TARGETS=proj1

ASM_SOURCE=proj1.asm

ASM_OBJECTS=${ASM_SOURCE:.asm=.o}

all: ${ALL_TARGETS}

#%.o: %.asm
#	${AS} ${ASFLAGS} $< -o $@

proj1.o: proj1.asm
	${AS} ${ASFLAGS} $< -o $@ -l proj1.lst

proj1: proj1.o
	${LD} ${LDFLAGS} -o $@ $<

clean:
	rm -f *.o ${ALL_TARGETS} *.lst