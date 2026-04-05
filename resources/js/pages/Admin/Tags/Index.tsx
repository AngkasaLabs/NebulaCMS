import { Head, Link, router } from '@inertiajs/react';
import { useState } from 'react';
import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { Input } from '@/components/ui/input';
import { Badge } from '@/components/ui/badge';
import { Plus, Tags } from 'lucide-react';
import { format } from 'date-fns';
import { id } from 'date-fns/locale';

interface Tag {
    id: number;
    name: string;
    slug: string;
    description: string;
    color: string;
    created_at: string;
    updated_at: string;
}

interface Props {
    tags: {
        data: Tag[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
    filters?: {
        search: string;
    };
}

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: route('admin.dashboard'),
    },
    {
        title: 'Tags'
    },
];

export default function Index({ tags, filters = { search: '' } }: Props) {
    const [search, setSearch] = useState(filters.search);

    const handleSearch = (value: string) => {
        setSearch(value);
        router.get(
            route('admin.tags.index'),
            { search: value },
            { preserveState: true }
        );
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Tags" />

            <div className="p-4">
                <div className="flex justify-between items-center mb-4">
                    <div>
                        <h1 className="text-2xl font-bold">Tags</h1>
                        <p className="text-muted-foreground">Manage and create tags for your content</p>
                    </div>
                    <Link href={route('admin.tags.create')}>
                        <Button>
                            <Plus className="mr-2 h-4 w-4" />
                            Create Tag
                        </Button>
                    </Link>
                </div>

                <div className="rounded-lg shadow border p-4 mb-4">
                    <div className="grid grid-cols-1 gap-4">
                        <div>
                            <Input
                                placeholder="Cari tag..."
                                value={search}
                                onChange={(e) => handleSearch(e.target.value)}
                                className="w-full text-gray-200 placeholder:text-gray-500"
                            />
                        </div>
                    </div>
                </div>

                <div className="rounded-lg shadow border">
                    {tags.data.length === 0 ? (
                        <div className="flex flex-col items-center justify-center py-12 px-4 rounded-lg">
                            <Tags className="h-12 w-12 mb-4" />
                            <h3 className="text-lg font-medium mb-1">No tags found</h3>
                            <p className="text-center mb-4">
                                {search
                                    ? 'No tags found with your search'
                                    : 'Start by creating a tag to categorize your content'}
                            </p>
                            <Link href={route('admin.tags.create')}>
                                <Button>
                                    <Plus className="mr-2 h-4 w-4" />
                                    Create First Tag
                                </Button>
                            </Link>
                        </div>
                    ) : (
                        <Table>
                            <TableHeader>
                                <TableRow className="border-b">
                                    <TableHead>Name</TableHead>
                                    <TableHead>Slug</TableHead>
                                    <TableHead>Description</TableHead>
                                    <TableHead>Color</TableHead>
                                    <TableHead>Created At</TableHead>
                                    <TableHead>Action</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {tags.data.map((tag) => (
                                    <TableRow key={tag.id}>
                                        <TableCell>{tag.name}</TableCell>
                                        <TableCell>{tag.slug}</TableCell>
                                        <TableCell>{tag.description}</TableCell>
                                        <TableCell>
                                            <Badge
                                                style={{
                                                    backgroundColor: tag.color,
                                                    color: getContrastColor(tag.color),
                                                }}
                                            >
                                                {tag.color}
                                            </Badge>
                                        </TableCell>
                                        <TableCell>
                                            {format(new Date(tag.created_at), 'dd MMMM yyyy', {
                                                locale: id,
                                            })}
                                        </TableCell>
                                        <TableCell>
                                            <div className="flex space-x-2">
                                                <Link href={route('admin.tags.edit', tag.id)}>
                                                    <Button variant="outline" size="sm">
                                                        Edit
                                                    </Button>
                                                </Link>
                                                <Link href={route('admin.tags.show', tag.id)}>
                                                    <Button variant="outline" size="sm">
                                                        View
                                                    </Button>
                                                </Link>
                                            </div>
                                        </TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    )}
                </div>

                {/* Pagination */}
                {tags.last_page > 1 && (
                    <div className="mt-4 flex justify-center">
                        <div className="flex space-x-2">
                            {Array.from({ length: tags.last_page }, (_, i) => i + 1).map(
                                (page) => (
                                    <Link
                                        key={page}
                                        href={route('admin.tags.index', { page })}
                                        className={`px-3 py-1 rounded ${
                                            page === tags.current_page
                                                ? 'bg-white text-black'
                                                : 'bg-gray-800 text-gray-200 hover:bg-[#0c1015]'
                                        }`}
                                    >
                                        {page}
                                    </Link>
                                ),
                            )}
                        </div>
                    </div>
                )}
            </div>
        </AppLayout>
    );
}

// Helper function to get contrasting text color based on background color
function getContrastColor(hexColor: string): string {
    // Remove the hash if it exists
    const color = hexColor.replace('#', '');

    // Convert hex to RGB
    const r = parseInt(color.substr(0, 2), 16);
    const g = parseInt(color.substr(2, 2), 16);
    const b = parseInt(color.substr(4, 2), 16);

    // Calculate the brightness
    const brightness = (r * 299 + g * 587 + b * 114) / 1000;

    // Return black or white based on brightness
    return brightness > 128 ? '#000000' : '#FFFFFF';
}
