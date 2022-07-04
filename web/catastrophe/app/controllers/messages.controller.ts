import { PrismaClient } from '@prisma/client'

export class Messages {
    _id: number;
    _content: string;
    _author: string;
    _prismaClient: PrismaClient;

    constructor(prisma: PrismaClient) {
        this.setPrismaClient(prisma)
    }

    // GET
    getId (): number {
        return this._id;
    }

    getContent (): string {
        return this._content;
    }

    getAuthor (): string {
        return this._author;
    }

    getPrismaClient (): PrismaClient {
        return this._prismaClient;
    }

    // SET
    setId (id: number): void {
        this._id = id;
    }

    setContent (content: string): void {
        this._content = content;
    }

    setAuthor (author: string): void {
        this._author = author;
    }

    setPrismaClient (prisma: PrismaClient): void {
        this._prismaClient = prisma;
    }

    // OTHER

    async getAllMessages (): Promise<object> {
        const prisma = this.getPrismaClient();
        const messages = await prisma.messages_tbl.findMany({
            select: {
                msg_content: true,
                users_tbl: {
                    select: {
                        usr_username: true
                    }
                }
            },
        })

        return messages
    }

    async deleteAllMessages (): Promise<void> {
        const prisma = this.getPrismaClient();
        try {
            await prisma.messages_tbl.deleteMany({
                where: {
                    usr_id: 2
                }
            })
            // await this.uploadMessage("Bah alors, on supprime ses messages ? >_<", 1)
        } catch (e) {
            console.error(e)
        }
    }

    async uploadMessage (message: string, id?: number): Promise<void> {
        const prisma = this.getPrismaClient();

        /*
        * Security
        */
        await prisma.messages_tbl.create({
            data: {
                msg_content: message,
                usr_id: (id) ? id : 2
            }
        })
    }

    // Cut database connection
    async deleteInstance (): Promise<void> {
        const prisma = this.getPrismaClient();
        await prisma.$disconnect();
    }
}