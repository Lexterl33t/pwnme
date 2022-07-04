import { Messages } from 'controllers/messages.controller';
import { PrismaClient } from "@prisma/client"

export default async function handler(req, res) {
    if (req.method === 'GET') {
        const prisma  = new PrismaClient()
        const message = new Messages(prisma);

        await message.deleteAllMessages();
        await message.deleteInstance();
        res.redirect(307, '/');
    } else {
        res.status(405).json({
            message: 'Method not allowed',
            cat: 'Padtentative d\'exploit l\'api !'
        });
    }
}